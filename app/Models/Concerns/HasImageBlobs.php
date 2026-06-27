<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Schema;

trait HasImageBlobs
{
    private static array $blobColumnCache = [];
    public static function bootHasImageBlobs(): void
    {
        static::saving(function ($model) {
            $model->storeBlobs();
        });
    }

    public function initializeHasImageBlobs(): void
    {
        foreach ($this->imageBlobFields() as $field => $cols) {
            $urlField = $field . '_url';
            if (!in_array($urlField, $this->appends, true)) {
                $this->appends[] = $urlField;
            }
        }
    }

    abstract protected function imageBlobFields(): array;

    public function hasAttribute($key)
    {
        if ($this->isImageUrlField($key)) {
            return true;
        }

        return parent::hasAttribute($key);
    }

    public function getAttributeValue($key)
    {
        if ($this->isImageUrlField($key, $field)) {
            return $this->getImageUrl($field);
        }

        return parent::getAttributeValue($key);
    }

    protected function mutateAttribute($key, $value)
    {
        if ($this->isImageUrlField($key, $field)) {
            return $this->getImageUrl($field);
        }

        return parent::mutateAttribute($key, $value);
    }

    private function isImageUrlField(string $key, ?string &$matchedField = null): bool
    {
        foreach ($this->imageBlobFields() as $field => $cols) {
            if ($key === $field . '_url') {
                $matchedField = $field;
                return true;
            }
        }

        return false;
    }

    protected function storeBlobs(): void
    {
        $table = $this->getTable();
        if (!isset(self::$blobColumnCache[$table])) {
            self::$blobColumnCache[$table] = [];
            foreach ($this->imageBlobFields() as $field => [$blobCol, $mimeCol]) {
                self::$blobColumnCache[$table][$field] = Schema::hasColumn($table, $blobCol);
            }
        }

        foreach ($this->imageBlobFields() as $field => [$blobCol, $mimeCol]) {
            try {
                if (!self::$blobColumnCache[$table][$field] ?? false) {
                    continue;
                }

                $path = $this->{$field};

                if (empty($path)) {
                    continue;
                }

                if (str_starts_with($path, 'data:')) {
                    continue;
                }

                if (str_starts_with($path, 'http')) {
                    continue;
                }

                if (isset($this->{$blobCol}) && !$this->isDirty($field)) {
                    continue;
                }

                $contents = $this->readFileContents($path);
                if ($contents !== null) {
                    $this->{$blobCol} = base64_encode($contents);
                    $this->{$mimeCol} = $this->detectMimeType($path, $contents);
                }
            } catch (\Throwable $e) {
                logger()->error('HasImageBlobs storeBlobs failed: ' . $e->getMessage(), [
                    'model' => static::class,
                    'field' => $field,
                ]);
            }
        }
    }

    protected function getBlobUrl(string $field): ?string
    {
        try {
            $fields = $this->imageBlobFields();
            if (!isset($fields[$field])) {
                return null;
            }

            [$blobCol, $mimeCol] = $fields[$field];
            $blob = $this->{$blobCol} ?? null;
            $mime = $this->{$mimeCol} ?? null;

            if ($blob && $mime) {
                return 'data:' . $mime . ';base64,' . $blob;
            }
        } catch (\Throwable $e) {
            logger()->error('HasImageBlobs getBlobUrl failed: ' . $e->getMessage());
        }

        return null;
    }

    public function getImageUrl(string $field): ?string
    {
        $fields = $this->imageBlobFields();
        if (!isset($fields[$field])) {
            return $this->{$field} ?? null;
        }

        $blobUrl = $this->getBlobUrl($field);
        if ($blobUrl) {
            return $blobUrl;
        }

        $path = $this->{$field} ?? null;
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http') || str_starts_with($path, 'data:')) {
            return $path;
        }

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }

    private function readFileContents(string $path): ?string
    {
        $candidates = [
            $path,
            storage_path('app/public/' . $path),
            public_path($path),
            public_path('storage/' . $path),
            base_path($path),
        ];

        foreach ($candidates as $candidate) {
            if (file_exists($candidate) && is_file($candidate)) {
                $contents = file_get_contents($candidate);
                return $contents !== false ? $contents : null;
            }
        }

        return null;
    }

    private function detectMimeType(string $path, string $contents): string
    {
        $candidates = [
            $path,
            storage_path('app/public/' . $path),
            public_path($path),
            public_path('storage/' . $path),
            base_path($path),
        ];

        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                $mime = mime_content_type($candidate);
                if ($mime) {
                    return $mime;
                }
            }
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $detected = $finfo->buffer($contents);
        return $detected ?: 'image/jpeg';
    }
}

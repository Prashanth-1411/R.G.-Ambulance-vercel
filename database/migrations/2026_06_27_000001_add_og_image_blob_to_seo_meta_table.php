<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_meta', function (Blueprint $table) {
            if (!Schema::hasColumn('seo_meta', 'og_image_blob')) {
                $table->longText('og_image_blob')->nullable()->after('og_image');
            }
            if (!Schema::hasColumn('seo_meta', 'og_image_mime')) {
                $table->string('og_image_mime', 50)->nullable()->after('og_image_blob');
            }
        });
    }

    public function down(): void
    {
        Schema::table('seo_meta', function (Blueprint $table) {
            $table->dropColumn(['og_image_blob', 'og_image_mime']);
        });
    }
};

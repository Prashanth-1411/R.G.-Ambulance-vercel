<?php
$module = [
    'table' => 'pages',
    'title' => 'Static Pages',
    'icon'  => 'ti-file-text',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'col' => 8],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'required' => true, 'col' => 4],
        ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'required' => true],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Published', 0 => 'Draft']],
    ],
    'columns' => ['id', 'title', 'slug', 'status', 'created_at'],
    'searchable' => ['title', 'content'],
    'order' => 'id DESC',
];
include __DIR__ . '/crud-base.php';

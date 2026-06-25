<?php
$module = [
    'table' => 'seo_meta',
    'title' => 'SEO Meta',
    'icon'  => 'ti-search',
    'fields' => [
        ['name' => 'page', 'label' => 'Page', 'type' => 'text', 'required' => true, 'col' => 6],
        ['name' => 'title', 'label' => 'Meta Title', 'type' => 'text', 'col' => 6],
        ['name' => 'description', 'label' => 'Meta Description', 'type' => 'textarea'],
        ['name' => 'keywords', 'label' => 'Keywords', 'type' => 'text', 'placeholder' => 'Comma separated'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive']],
    ],
    'columns' => ['id', 'page', 'title', 'status', 'created_at'],
    'searchable' => ['page', 'title', 'description'],
    'order' => 'page ASC',
];
include __DIR__ . '/crud-base.php';

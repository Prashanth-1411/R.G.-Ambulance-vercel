<?php
$module = [
    'table' => 'hero_slides',
    'title' => 'Hero Slides',
    'icon'  => 'ti-slideshow',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
        ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'text', 'col' => 10],
        ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'path' => 'uploads/hero/'],
        ['name' => 'badge_text', 'label' => 'Badge Text', 'type' => 'text'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0, 'col' => 4],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive'], 'col' => 4],
    ],
    'columns' => ['id', 'title', 'badge_text', 'sort_order', 'status', 'created_at'],
    'searchable' => ['title', 'subtitle'],
    'order' => 'sort_order ASC',
];
include __DIR__ . '/crud-base.php';

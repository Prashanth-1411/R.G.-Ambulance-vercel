<?php
$module = [
    'table' => 'albums',
    'title' => 'Gallery Albums',
    'icon'  => 'ti-photo',
    'fields' => [
        ['name' => 'title', 'label' => 'Album Title', 'type' => 'text', 'required' => true, 'col' => 8],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'col' => 4],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0, 'col' => 6],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive'], 'col' => 6],
    ],
    'columns' => ['id', 'title', 'sort_order', 'status', 'created_at'],
    'searchable' => ['title', 'description'],
    'order' => 'sort_order ASC',
];
include __DIR__ . '/crud-base.php';

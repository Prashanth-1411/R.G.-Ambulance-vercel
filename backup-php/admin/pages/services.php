<?php
$module = [
    'table' => 'services',
    'title' => 'Services',
    'icon'  => 'ti-truck',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
        ['name' => 'service_type', 'label' => 'Service Type', 'type' => 'select', 'options' => ['ambulance' => 'Ambulance', 'funeral' => 'Funeral'], 'required' => true],
        ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'path' => 'uploads/services/'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive']],
    ],
    'columns' => ['id', 'title', 'service_type', 'sort_order', 'status', 'created_at'],
    'searchable' => ['title', 'description'],
    'order' => 'sort_order ASC',
    'has_sort' => true,
];
include __DIR__ . '/crud-base.php';

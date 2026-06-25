<?php
$module = [
    'table' => 'sister_concerns',
    'title' => 'Sister Concerns',
    'icon'  => 'ti-building',
    'fields' => [
        ['name' => 'name', 'label' => 'Company Name', 'type' => 'text', 'required' => true, 'col' => 8],
        ['name' => 'icon', 'label' => 'Icon Class', 'type' => 'text', 'placeholder' => 'ti ti-building', 'col' => 4],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
        ['name' => 'website', 'label' => 'Website', 'type' => 'text', 'placeholder' => 'https://'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0, 'col' => 4],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive'], 'col' => 4],
    ],
    'columns' => ['id', 'name', 'website', 'sort_order', 'status', 'created_at'],
    'searchable' => ['name', 'description'],
    'order' => 'sort_order ASC',
];
include __DIR__ . '/crud-base.php';

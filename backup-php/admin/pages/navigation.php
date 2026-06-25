<?php
$module = [
    'table' => 'navigation_items',
    'title' => 'Navigation',
    'icon'  => 'ti-menu-2',
    'fields' => [
        ['name' => 'label', 'label' => 'Label', 'type' => 'text', 'required' => true, 'col' => 6],
        ['name' => 'link', 'label' => 'URL', 'type' => 'text', 'required' => true, 'col' => 6],
        ['name' => 'parent_id', 'label' => 'Parent ID', 'type' => 'number', 'default' => 0, 'col' => 3],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0, 'col' => 3],
        ['name' => 'location', 'label' => 'Location', 'type' => 'select', 'options' => ['header' => 'Header', 'footer' => 'Footer'], 'col' => 3],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive'], 'col' => 3],
    ],
    'columns' => ['id', 'label', 'link', 'parent_id', 'sort_order', 'status', 'created_at'],
    'searchable' => ['label', 'link'],
    'order' => 'sort_order ASC',
];
include __DIR__ . '/crud-base.php';

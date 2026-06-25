<?php
$module = [
    'table' => 'team_members',
    'title' => 'Team Members',
    'icon'  => 'ti-users',
    'fields' => [
        ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
        ['name' => 'designation', 'label' => 'Designation', 'type' => 'text', 'required' => true, 'col' => 6],
        ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'path' => 'uploads/team/'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0, 'col' => 4],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive'], 'col' => 4],
    ],
    'columns' => ['id', 'name', 'designation', 'sort_order', 'status', 'created_at'],
    'searchable' => ['name', 'designation'],
    'order' => 'sort_order ASC',
];
include __DIR__ . '/crud-base.php';

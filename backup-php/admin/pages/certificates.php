<?php
$module = [
    'table' => 'certificates',
    'title' => 'Certificates',
    'icon'  => 'ti-certificate',
    'fields' => [
        ['name' => 'title', 'label' => 'Certificate Title', 'type' => 'text', 'required' => true, 'col' => 6],
        ['name' => 'issuer', 'label' => 'Issuer', 'type' => 'text', 'col' => 6],
        ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'path' => 'uploads/certificates/'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0, 'col' => 4],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive'], 'col' => 4],
    ],
    'columns' => ['id', 'title', 'issuer', 'sort_order', 'status', 'created_at'],
    'searchable' => ['title', 'issuer'],
    'order' => 'sort_order ASC',
];
include __DIR__ . '/crud-base.php';

<?php
$module = [
    'table' => 'company_timeline',
    'title' => 'Company Timeline',
    'icon'  => 'ti-timeline',
    'fields' => [
        ['name' => 'year', 'label' => 'Year', 'type' => 'text', 'required' => true, 'col' => 4],
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'col' => 8],
        ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
        ['name' => 'is_highlight', 'label' => 'Highlight', 'type' => 'select', 'options' => [1 => 'Yes', 0 => 'No'], 'col' => 4],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive'], 'col' => 4],
    ],
    'columns' => ['id', 'year', 'title', 'is_highlight', 'status', 'created_at'],
    'searchable' => ['title', 'description', 'year'],
    'order' => 'year ASC',
];
include __DIR__ . '/crud-base.php';

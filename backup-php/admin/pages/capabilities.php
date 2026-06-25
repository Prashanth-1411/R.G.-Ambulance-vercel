<?php
$module = [
    'table' => 'capabilities',
    'title' => 'Capabilities',
    'icon'  => 'ti-chart-bar',
    'fields' => [
        ['name' => 'label', 'label' => 'Label', 'type' => 'text', 'required' => true, 'col' => 6],
        ['name' => 'value', 'label' => 'Value', 'type' => 'text', 'required' => true, 'placeholder' => 'e.g. 500+', 'col' => 6],
        ['name' => 'icon', 'label' => 'Icon Class', 'type' => 'text', 'placeholder' => 'ti ti-users'],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0, 'col' => 4],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive'], 'col' => 4],
    ],
    'columns' => ['id', 'label', 'value', 'sort_order', 'status', 'created_at'],
    'searchable' => ['label'],
    'order' => 'sort_order ASC',
];
include __DIR__ . '/crud-base.php';

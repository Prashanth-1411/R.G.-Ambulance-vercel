<?php
$module = [
    'table' => 'testimonials',
    'title' => 'Testimonials',
    'icon'  => 'ti-message-star',
    'fields' => [
        ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
        ['name' => 'designation', 'label' => 'Designation', 'type' => 'text', 'col' => 6],
        ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'required' => true],
        ['name' => 'rating', 'label' => 'Rating', 'type' => 'select', 'options' => [5 => '★★★★★', 4 => '★★★★', 3 => '★★★', 2 => '★★', 1 => '★'], 'col' => 4],
        ['name' => 'category', 'label' => 'Category', 'type' => 'select', 'options' => ['ambulance' => 'Ambulance', 'funeral' => 'Funeral', 'icu' => 'ICU Transfer', 'long' => 'Long Distance'], 'col' => 4],
        ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'default' => 0, 'col' => 4],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Active', 0 => 'Inactive'], 'col' => 6],
    ],
    'columns' => ['id', 'name', 'rating', 'category', 'sort_order', 'status', 'created_at'],
    'searchable' => ['name', 'content'],
    'order' => 'sort_order ASC, id DESC',
];
include __DIR__ . '/crud-base.php';

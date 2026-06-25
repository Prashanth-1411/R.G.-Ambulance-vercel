<?php
$module = [
    'table' => 'bookings',
    'title' => 'Bookings',
    'icon'  => 'ti-calendar-stats',
    'module_type' => 'readonly',
    'fields' => [
        ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
        ['name' => 'phone', 'label' => 'Phone', 'type' => 'text', 'col' => 6],
        ['name' => 'pickup', 'label' => 'Pickup', 'type' => 'text'],
        ['name' => 'destination', 'label' => 'Destination', 'type' => 'text'],
        ['name' => 'service_name', 'label' => 'Service', 'type' => 'text', 'col' => 6],
        ['name' => 'booking_date', 'label' => 'Booking Date', 'type' => 'date', 'col' => 6],
        ['name' => 'notes', 'label' => 'Notes', 'type' => 'textarea'],
        ['name' => 'booking_type', 'label' => 'Type', 'type' => 'select', 'options' => ['ambulance' => 'Ambulance', 'funeral' => 'Funeral']],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['pending' => 'Pending', 'confirmed' => 'Confirmed', 'completed' => 'Completed', 'cancelled' => 'Cancelled']],
    ],
    'columns' => ['id', 'name', 'phone', 'service_name', 'booking_type', 'booking_date', 'status', 'created_at'],
    'searchable' => ['name', 'phone', 'pickup', 'destination', 'service_name'],
    'order' => 'created_at DESC',
];
include __DIR__ . '/crud-base.php';

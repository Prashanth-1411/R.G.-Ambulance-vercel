<?php
$module = [
    'table' => 'contact_inquiries',
    'title' => 'Contact Inquiries',
    'icon'  => 'ti-mail',
    'module_type' => 'readonly',
    'fields' => [
        ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'col' => 6],
        ['name' => 'email', 'label' => 'Email', 'type' => 'text', 'col' => 6],
        ['name' => 'phone', 'label' => 'Phone', 'type' => 'text', 'col' => 6],
        ['name' => 'subject', 'label' => 'Subject', 'type' => 'text', 'col' => 6],
        ['name' => 'message', 'label' => 'Message', 'type' => 'textarea'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['unread' => 'Unread', 'read' => 'Read', 'replied' => 'Replied']],
    ],
    'columns' => ['id', 'name', 'email', 'subject', 'status', 'created_at'],
    'searchable' => ['name', 'email', 'subject', 'message'],
    'order' => 'created_at DESC',
];
include __DIR__ . '/crud-base.php';

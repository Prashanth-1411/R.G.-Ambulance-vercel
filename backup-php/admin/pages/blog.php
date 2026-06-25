<?php
$module = [
    'table' => 'blog_posts',
    'title' => 'Blog Posts',
    'icon'  => 'ti-news',
    'fields' => [
        ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'col' => 8],
        ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'required' => true, 'col' => 4],
        ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'required' => true],
        ['name' => 'image', 'label' => 'Image', 'type' => 'file', 'path' => 'uploads/blog/'],
        ['name' => 'category_id', 'label' => 'Category', 'type' => 'text', 'placeholder' => 'Category ID', 'col' => 4],
        ['name' => 'reading_time', 'label' => 'Reading Time', 'type' => 'text', 'placeholder' => 'e.g. 5 min read', 'col' => 4],
        ['name' => 'tags', 'label' => 'Tags', 'type' => 'text', 'placeholder' => 'Comma separated', 'col' => 4],
        ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => [1 => 'Published', 0 => 'Draft']],
    ],
    'columns' => ['id', 'title', 'category_id', 'views', 'status', 'created_at'],
    'searchable' => ['title', 'content', 'tags'],
    'order' => 'created_at DESC',
];
include __DIR__ . '/crud-base.php';

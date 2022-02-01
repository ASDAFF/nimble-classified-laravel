<?php

return [
    'parent' => 'parent_id',
    'primary_key' => 'id',
    'generate_url' => true,
    'childNode' => 'child',
    'body' => [
        'id',
        'name',
        'slug',
        'icon'
    ],
    'html' => [
        'label' => 'name',
        'href' => 'slug'
    ],
    'dropdown' => [
        'prefix' => '',
        'label' => 'name',
        'value' => 'id',
    ]
];

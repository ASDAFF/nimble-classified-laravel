<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'profile-settings',
        'users',
        'user/loadEdit',
        'delete',
        'email-settings',
        'change-status',
        'category',
        'delete-category',
        'load-category',
        'upload-ads-images',
        'delete-ads-images',
        'load-city',
        'delete-category',
        'load-category',
        'customfields',
        'customfields-remove',
        'load-customfields',
        'ajax-search',
        'groups',
        'group_fields',
        'delete_group',
        'user-profile-settings',
        'change-password',
        'load-comune',
        'load_chat_head',
        'chat',
        'load_chat_message',
        'check_email',
        'user-login',
        'user-id-card',
        'chat_notify',
        'contact-user',
        'load-edited-customfields',
        'load_message_head',
        'message',
        'load_message',
        'message_notify',
        'setting'
    ];
}

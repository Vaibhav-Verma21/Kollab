<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('whiteboard.{uuid}', function ($user, $uuid) {
    if (auth()->check()) {
        $colors = ['#ef4444', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#14b8a6', '#f43f5e', '#a855f7', '#06b6d4'];
        $index = hexdec(substr(md5($user->id), 0, 4)) % count($colors);
        return [
            'id' => $user->id,
            'name' => $user->name,
            'color' => $colors[$index],
        ];
    }
    return false;
});

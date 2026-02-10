<?php

return [

    'models' => [
        'permission' => Spatie\Permission\Models\Permission::class,
        'role' => Spatie\Permission\Models\Role::class,
    ],

    'teams' => false, // <-- TAMBAHKAN INI

    'column_names' => [
        'role_pivot_key' => 'role_id',
        'permission_pivot_key' => 'permission_id',
        'model_morph_key' => 'model_id',
        'team_foreign_key' => 'team_id',
    ],

    'display_permission_in_exception' => false,
    'display_permission_in_exception_with_debug' => true,
    'enable_wildcard_permission' => false,
    'cache_store' => null,
    'cache_reset_on_update' => true,
    'cache_expiration_time' => 1440,
];

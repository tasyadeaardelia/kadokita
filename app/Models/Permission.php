<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;
// use App\Models\Concerns\UuidTrait;

class Permission extends SpatiePermission
{
    // use HasFactory, UuidTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'guard_name',
    ];

    // protected $primaryKey = 'id';
    // protected $keyType = 'string';
    // public $incrementing = false;

    // public static function defaultPermissions()
    // {
    //     return [
    //         'view_roles',
    //         'add_roles',
    //         'edit_roles',
    //         'delete_roles',

    //         'view_users',
    //         'add_users',
    //         'edit_users',
    //         'delete_users',

    //         'view_posts',
    //         'add_posts',
    //         'edit_posts',
    //         'delete_posts',
    //     ];
    // }
}

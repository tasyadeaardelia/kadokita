<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
// use App\Models\Concerns\UuidTrait;

class Role extends SpatieRole
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
}

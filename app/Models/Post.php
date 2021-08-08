<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    // use HasFactory, UuidTrait, SoftDeletes;

    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title', 'slug', 'image', 'content', 'publishedAt', 'status', 'user_id', 
    ];

    // protected $primaryKey = 'id';
    // protected $keyType = 'string';

    // public function getIncrementing()
    // {
    //     return false;
    // }

    public function posttags()
    {
        return $this->hasMany(Post_Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

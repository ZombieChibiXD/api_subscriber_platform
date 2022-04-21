<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    public $id;

    public $name;

    public $url;

    public $description;

    public $category;

    public $user_id;

    public $created_at;

    public $updated_at;

    /**
     * The attributes should be cast to native types.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'url' => 'string',
        'description' => 'string',
        'category' => 'string',
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function subscribers()
    {
        return $this->hasManyThrough(Subscription::class, User::class);
    }


}

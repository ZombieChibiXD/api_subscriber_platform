<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // public $id;
    // public $website_id;
    // public $title;
    // public $tags;
    // public $url;
    // public $content;
    // public $created_at;
    // public $updated_at;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'id' => 'integer',
        'website_id' => 'integer',
        'title' => 'string',
        'tags' => 'string',
        'url' => 'string',
        'content' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'created_at',
    //     'updated_at',
    // ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}

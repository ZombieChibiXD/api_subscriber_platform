<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public $id;

    public $user_id;

    public $website_id;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}

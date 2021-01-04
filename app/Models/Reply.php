<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'reviewsreplies';

    protected $fillable = [
        '_token',
        'steamid',
        'reply',
        'review_id'
    ];
}

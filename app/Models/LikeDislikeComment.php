<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeDislikeComment extends Model
{
    use HasFactory;
    protected $table = 'likes_dislikes_comments'; 
    protected $fillable = [
        'comment_id',
        'ip_address',
        'like',
        'dislike',
    ];
}

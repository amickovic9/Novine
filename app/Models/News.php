<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'naslovna',
        'naslov',
        'tekst',
        'rubrika',
        'draft',
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }
    public function user()
{
    return $this->hasOne(User::class, 'id', 'user_id');
}

    public function deleteRequest()
    {
        return $this->hasOne(ArticleDeleteRequest::class, 'article_id', 'id');
    }
    public function editRequest()
    {
        return $this->hasOne(ArticleEditRequests::class, 'article_id', 'id');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'rubrika');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags');
    }
    public function dislikes()
    {
        return $this->hasMany(Dislikes::class, 'article_id');
    }
    public function likes()
    {
        return $this->hasMany(Likes::class, 'article_id');
    }
    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'naslov',
        'tekst',
        'rubrika',
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
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
    public function likes()
    {
        return $this->hasMany(Likes::class, 'article_id');
    }
}

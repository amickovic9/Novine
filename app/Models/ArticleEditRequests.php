<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleEditRequests extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id',
        'category_id',
        'naslov',
        'naslovna',
        'tekst',
        'rubrika',
    ];
    public function news()
    {
        return $this->belongsTo(News::class, 'article_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags', 'news_id', 'tag_id');
    }
    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'news_id');
    }

}

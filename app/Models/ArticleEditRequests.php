<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleEditRequests extends Model
{
    use HasFactory;
     protected $fillable = [
        'article_id',
        'naslov',
        'tekst',
        'rubrika',
    ];
    public function news()
        {
            return $this->belongsTo(News::class, 'article_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleDeleteRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id',
        'category_id',
    ];
    public function news()
        {
             return $this->belongsTo(News::class, 'article_id', 'id');
    }

}

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
    public function comments(){
        return $this->hasMany(Comment::class,'article_id');
    }
    public function user(){
        return $this->hasOne(User::class,'user_id');
    }
    
}

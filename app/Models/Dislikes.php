<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dislikes extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id',
        'ip_address',
    ];
    public function news(){
        return $this->hasOne(News::class,'id' ,'article_id');
    }
}

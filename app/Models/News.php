<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'naslov',
        'tekst',
        'rubrika',
    ];
    public function comments(){
        return $this->hasMany(Comments::class,'article_id');
    }
}

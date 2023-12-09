<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category'
    ];
   
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_categories', 'category_id', 'user_id')->withPivot('id');
    }
}
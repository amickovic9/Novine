<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;
    public function definition()
    {
        return [
            'user_id' => 1,
            'naslovna' => 'naslovna.jpg',
            'naslov' => $this->faker->sentence,
            'tekst' => $this->faker->sentence,
            'rubrika' => 1,
            'draft'=>0,
        ];
    }
    
    
}

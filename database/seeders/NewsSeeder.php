<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Category;
use App\Models\User;
use Faker\Factory as Faker;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        $users = User::all();
        $faker = Faker::create();
        $startDate = now()->subYears(5);
        
        // Lista imena slika
        $imageNames = ['naslovna_0.jpg', 'naslovna_1.jpg', 'naslovna_2.jpg', 'naslovna_3.jpg', 'naslovna_4.jpg', 'naslovna_5.jpg', 'naslovna_6.jpg', 'naslovna_7.jpg', 'naslovna_8.jpg', 'naslovna_9.jpg'];

        for ($i = 0; $i < 5 * 365; $i++) {
            $category = $categories->random();
            $user = $users->random();
            $title = $faker->sentence;
            $content = $faker->paragraphs(3, true);

            $imageFileName = $imageNames[$i % count($imageNames)];

            News::create([
                'user_id' => $user->id,
                'naslov' => $title,
                'tekst' => $content,
                'naslovna' => $imageFileName,
                'rubrika' => $category->id,
                'created_at' => $startDate->addDay(),
                'updated_at' => $startDate->addDay(),
                'draft' => 0,
            ]);

            $imagePath = storage_path('naslovne/' . $imageFileName);
            file_put_contents($imagePath, file_get_contents($faker->imageUrl(400, 400, 'cats')));
        }
    }
}

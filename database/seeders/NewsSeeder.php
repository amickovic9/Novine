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
        for ($i = 0; $i < 5 * 365; $i++) {
            $category = $categories->random();
            $user = $users->random();
            $title = $faker->sentence;
            $content = $faker->paragraphs(3, true);
            $draft = rand(0, 1);


            if ($draft) {
                $title = "Draft: " . $title;
                $content = "Draft content: " . $content;
            }


            $rubrikaId = $category->id;


            $imageFileName = 'naslovna_' . $i . '.jpg';

            News::create([
                'user_id' => $user->id,
                'naslov' => $title,
                'tekst' => $content,
                'naslovna' => $imageFileName,
                'rubrika' => $rubrikaId, 
                'created_at' => $startDate->addDay(), 
                'updated_at' => $startDate->addDay(),
            ]);


            $imagePath = public_path('images/' . $imageFileName);
            file_put_contents($imagePath, file_get_contents($faker->imageUrl(800, 600, 'cats')));
        }
    }
}
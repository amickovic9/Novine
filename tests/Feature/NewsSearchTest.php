<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function Pretraga_po_Naslovu()
    {
        $news1 = News::factory()->create(['naslov' => 'Prva Vest']);
        $news2 = News::factory()->create(['naslov' => 'Druga Vest']);

        $response = $this->get('/?pretraga=Prva');

        $response->assertStatus(200);
        $response->assertSee($news1->naslov);
        $response->assertDontSee($news2->naslov);
    }

    /** @test */
    public function Pretraga_po_Kategoriji()
    {
        $category1 = Category::factory()->create(['category' => 'Prva Rubrika']);
        $category2 = Category::factory()->create(['category' => 'Druga Rubrika']);

        $news1 = News::factory()->create(['rubrika' => $category1->id]);
        $news2 = News::factory()->create(['rubrika' => $category2->id]);

        $response = $this->get('/?pretraga=Prva');

        $response->assertStatus(200);
        $response->assertSee($news1->naslov);
        $response->assertDontSee($news2->naslov);
    }

    /** @test */
    public function Pretraga_po_Datumu()
    {
        $news1 = News::factory()->create(['created_at' => '2022-01-01 00:00:00']);
        $news2 = News::factory()->create(['created_at' => '2022-02-01 00:00:00']);

        $response = $this->get('/?date=2022-01-01');

        $response->assertStatus(200);
        $response->assertSee($news1->naslov);
        $response->assertDontSee($news2->naslov);
    }

    /** @test */
    public function Pretraga_po_Tagu()
    {
        $tag = \App\Models\Tag::factory()->create(['name' => 'TestTag']);

        $news = News::factory()->create(['naslov' => 'Vest Test']);

        $news->tags()->attach($tag->id);

        $response = $this->get('/?pretraga=TestTag');
        $response->assertStatus(200);
        $response->assertSee($news->naslov);
    }
}
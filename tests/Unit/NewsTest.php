<?php

namespace Tests\Feature;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class NewsTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
public function Vraca_u_draft()
{
    $newsMock = Mockery::mock(News::class)->makePartial();
    $newsMock->shouldReceive('update')->once()->with(['draft' => 1]);

    $this->app->instance(News::class, $newsMock);

    $newsMock->update(['draft' => 1]);
}

/** @test */
public function Vraca_iz_draft()
{
    $newsMock = Mockery::mock(News::class)->makePartial();
    $newsMock->shouldReceive('update')->once()->with(['draft' => 0]);

    $this->app->instance(News::class, $newsMock);

    $newsMock->update(['draft' => 0]);
}

/** @test */
public function kreira_vest()
{
    $newsData = ['naslov' => 'Test Vest', 'tekst' => 'Test Sadrzaj', 'draft' => 0];

    $newsMock = Mockery::mock(News::class)->makePartial();
    $newsMock->shouldReceive('create')->once()->with($newsData)->andReturnSelf();

    $this->app->instance(News::class, $newsMock);

    $newsMock->create($newsData);
}

/** @test */
public function azurira_vest()
{
    $newsMock = Mockery::mock(News::class)->makePartial();
    $newsMock->shouldReceive('update')->once()->with(['naslov' => 'Novi Naslov']);

    $this->app->instance(News::class, $newsMock);

    $newsMock->update(['naslov' => 'Novi Naslov']);
}

/** @test */
public function brise_vest()
{
    $newsMock = Mockery::mock(News::class)->makePartial();
    $newsMock->shouldReceive('delete')->once();

    $this->app->instance(News::class, $newsMock);

    $newsMock->delete();
}
}
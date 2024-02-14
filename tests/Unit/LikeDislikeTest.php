<?php

namespace Tests\Unit;

use App\Models\Likes;
use App\Models\Dislikes;
use App\Models\News;
use Tests\TestCase;

class LikeDislikeTest extends TestCase
{
    /** @test */
    public function kreiranje_lajka()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $like = new Likes([
            'article_id' => $news->id,
            'ip_address' => '127.0.0.1',
        ]);

        $this->assertEquals(1, $like->article_id);
        $this->assertEquals('127.0.0.1', $like->ip_address);
    }

    /** @test */
    public function kreiranje_dislajka()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $dislike = new Dislikes([
            'article_id' => $news->id,
            'ip_address' => '127.0.0.1',
        ]);

        $this->assertEquals(1, $dislike->article_id);
        $this->assertEquals('127.0.0.1', $dislike->ip_address);
    }

    /** @test */
    public function ne_moze_da_lajkuje_bez_id_article()
    {
        $like = \Mockery::mock(Likes::class)->makePartial();
        $like->shouldReceive('save')->once();

        $like->ip_address = '127.0.0.1';
        $like->save();
    }

    /** @test */
    public function ne_moze_da_dislajkuje_bez_id_article()
    {
        $dislike = \Mockery::mock(Dislikes::class)->makePartial();
        $dislike->shouldReceive('save')->once();

        $dislike->ip_address = '127.0.0.1';
        $dislike->save();
    }

    /** @test */
    public function ne_moze_da_lajkuje_Bez_ip_adrese()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $like = \Mockery::mock(Likes::class)->makePartial();
        $like->shouldReceive('save')->once()->andThrow(new \Exception('IP address required'));

        $like->article_id = $news->id;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('IP address required');

        $like->save();
    }

    /** @test */
public function ne_moze_da_dislajkuje_Bez_ip_adrese()
{
    $news = \Mockery::mock(News::class)->makePartial();
    $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

    $dislike = \Mockery::mock(Dislikes::class)->makePartial();
    $dislike->shouldReceive('save')->once()->andThrow(new \Exception('IP address required'));

    $dislike->article_id = $news->id;

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('IP address required');

    $dislike->save();
}

    /** @test */
    public function moze_da_obrise_lajk()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $like = \Mockery::mock(Likes::class)->makePartial();
        $like->shouldReceive('delete');

        $like->article_id = $news->id;
        $like->ip_address = '127.0.0.1';

        $like->delete();

        $this->assertNull(Likes::find($like->id));
    }

    /** @test */
    public function moze_da_obrise_dislajk()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $dislike = \Mockery::mock(Dislikes::class)->makePartial();
        $dislike->shouldReceive('delete');

        $dislike->article_id = $news->id;
        $dislike->ip_address = '127.0.0.1';

        $dislike->delete();

        $this->assertNull(Dislikes::find($dislike->id));
    }

    /** @test */
    public function moze_da_azurira_lajk()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $like = \Mockery::mock(Likes::class)->makePartial();
        $like->shouldReceive('save')->once();

        $like->article_id = $news->id;
        $like->ip_address = '127.0.0.1';

        $like->ip_address = '127.0.0.2';
        $like->save();

        $this->assertEquals('127.0.0.2', $like->ip_address);
    }

    /** @test */
    public function moze_da_azurira_dislajke()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $dislike = \Mockery::mock(Dislikes::class)->makePartial();
        $dislike->shouldReceive('save')->once();

        $dislike->article_id = $news->id;
        $dislike->ip_address = '127.0.0.1';

        $dislike->ip_address = '127.0.0.2';
        $dislike->save();

        $this->assertEquals('127.0.0.2', $dislike->ip_address);
    }
}
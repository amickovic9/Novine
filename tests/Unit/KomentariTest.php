<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\News;
use Tests\TestCase;

class KomentariTest extends TestCase
{
    /** @test */
public function Kreiranje_komentara()
{
    $news = \Mockery::mock(News::class)->makePartial();
    $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

    $comment = \Mockery::mock(Comment::class)->makePartial();
    $comment->shouldReceive('getAttribute')->with('content')->andReturn('Ovo je komentar');
    $comment->shouldReceive('setAttribute')->with('content', 'Ovo je komentar');

    $comment->article_id = $news->id;
    $comment->content = 'Ovo je komentar';

    $this->assertEquals(1, $comment->article_id);
    $this->assertEquals('Ovo je komentar', $comment->content);
}

    /** @test */
    public function Ne_moze_da_kreira_komentar_bez_id_artikla()
    {
        $comment = \Mockery::mock(Comment::class)->makePartial();
        $comment->shouldReceive('save')->once();

        $comment->content = 'Ovo je komentar';
        $comment->save();
    }

    /** @test */
    public function Ne_moze_da_kreira_komentar_bez_sadrzaja()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $comment = \Mockery::mock(Comment::class)->makePartial();
        $comment->shouldReceive('save')->once();

        $comment->article_id = $news->id;
        $comment->save();
    }

    /** @test */
    public function Update_Komentara()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $comment = \Mockery::mock(Comment::class)->makePartial();
        $comment->shouldReceive('save')->once();

        $comment->article_id = $news->id;
        $comment->content = 'Ovo je komentar';

        $comment->content = 'Ovo je azuriran komentar';
        $comment->save();

        $this->assertEquals('Ovo je azuriran komentar', $comment->content);
    }

    /** @test */
    public function Brisanje_Komentara()
    {
        $news = \Mockery::mock(News::class)->makePartial();
        $news->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $comment = \Mockery::mock(Comment::class)->makePartial();
        $comment->shouldReceive('delete');

        $comment->article_id = $news->id;
        $comment->content = 'Ovo je komentar';

        $comment->delete();

        $this->assertNull(Comment::find($comment->id));
    }
}
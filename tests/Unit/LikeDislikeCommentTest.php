<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\LikeDislikeComment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeDislikeCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function Lajk_Dodat_Na_Komentar()
    {
        $commentMock = \Mockery::mock(Comment::class)->makePartial();
        $commentMock->id = 1;

        $likeDislikeCommentMock = \Mockery::mock(LikeDislikeComment::class);
        $likeDislikeCommentMock->shouldReceive('create')
            ->once()
            ->with([
                'comment_id' => $commentMock->id,
                'ip_address' => '127.0.0.1',
                'like' => 1,
                'dislike' => 0,
            ])
            ->andReturnSelf();

        $this->app->instance(LikeDislikeComment::class, $likeDislikeCommentMock);

        $likeDislikeCommentMock->create([
            'comment_id' => $commentMock->id,
            'ip_address' => '127.0.0.1',
            'like' => 1,
            'dislike' => 0,
        ]);
    }

    /** @test */
    public function Dislajk_Dodat_Na_Komentar()
    {
        $commentMock = \Mockery::mock(Comment::class)->makePartial();
        $commentMock->id = 1;

        $likeDislikeCommentMock = \Mockery::mock(LikeDislikeComment::class);
        $likeDislikeCommentMock->shouldReceive('create')
            ->once()
            ->with([
                'comment_id' => $commentMock->id,
                'ip_address' => '127.0.0.1',
                'like' => 0,
                'dislike' => 1,
            ])
            ->andReturnSelf();

        $this->app->instance(LikeDislikeComment::class, $likeDislikeCommentMock);

        $likeDislikeCommentMock->create([
            'comment_id' => $commentMock->id,
            'ip_address' => '127.0.0.1',
            'like' => 0,
            'dislike' => 1,
        ]);
    }
}
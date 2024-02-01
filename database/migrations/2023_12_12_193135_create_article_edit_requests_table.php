<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleEditRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_edit_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id');
            $table->foreignId('category_id');
            $table->string('naslov')->nullable()->default(null);;
            $table->string('naslovna');
            $table->text('tekst')->nullable()->change();

            $table->foreignId('rubrika');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_edit_requests');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group');
            $table->string('key');
            $table->text('text');
            $table->timestamp('sync_at')->nullable();
            $table->timestamps();

            $table->index('group');
            $table->index('key');
            $table->index(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('language_lines');
    }
}

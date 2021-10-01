<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoryTagsTable extends Migration
{
    public function up()
    {
        Schema::create('repository_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id')->constrained('repositories');
            $table->foreignId('tag_id')->constrained('tags');
        });
    }

    public function down()
    {
        Schema::dropIfExists('repository_tags');
    }
}

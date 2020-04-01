<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extensions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->json('repository')->nullable();
            $table->string('latest_dist_tag')->nullable();
            $table->unsignedInteger('version_count')->default(0);
            $table->unsignedInteger('weekly_download_count')->default(0);
            $table->string('license')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('extensions');
    }
}

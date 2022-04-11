<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('seo_name')->unique();
            $table->string('anchor_title')->nullable();

            $table->string('title')->nullable();
            $table->string('h1')->nullable();
            $table->text('description')->nullable();
            $table->text('annotation')->nullable();

            $table->bigInteger('group_id')->nullable()->unsigned();
            $table->bigInteger('parent_id')->nullable();
            $table->tinyInteger('show_in_menu')->default(0);

            $table->tinyInteger('status')->default(0);
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->bigInteger('deleted_by')->nullable()->unsigned();

            $table->timestamps();
            $table->tinyInteger('deleted')->default(0);
            $table->timestamp('deleted_at')->nullable();

            $table->bigInteger('site_id')->unsigned();
            $table->bigInteger('templates_count')->nullable();

            $table->foreign('group_id')->references('id')->on('category_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};

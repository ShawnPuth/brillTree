<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDendrogramNestedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dendrogram_nested', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->integer('left')->default(0);
            $table->integer('right')->default(0);
            $table->integer('depth')->default(0);
        });

        \Illuminate\Support\Facades\DB::table('dendrogram_nested')->insert([
            ["id"=>1,"left"=>1,"right"=>22,"depth"=>0,"name"=>"衣服"],
            ["id"=>2,"left"=>2,"right"=>9,"depth"=>1,"name"=>"男衣"],
            ["id"=>3,"left"=>10,"right"=>21,"depth"=>1,"name"=>"女衣"],
            ["id"=>4,"left"=>3,"right"=>8,"depth"=>2,"name"=>"正装"],
            ["id"=>5,"left"=>4,"right"=>5,"depth"=>3,"name"=>"衬衫"],
            ["id"=>6,"left"=>6,"right"=>7,"depth"=>3,"name"=>"夹克"],
            ["id"=>7,"left"=>11,"right"=>16,"depth"=>2,"name"=>"裙子"],
            ["id"=>8,"left"=>17,"right"=>18,"depth"=>2,"name"=>"短裙"],
            ["id"=>9,"left"=>19,"right"=>20,"depth"=>2,"name"=>"开衫"],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dendrogram_nested');
    }
}

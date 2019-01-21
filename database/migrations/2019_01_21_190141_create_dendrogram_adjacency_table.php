<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDendrogramAdjacencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dendrogram_adjacency', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('p_id')->default(0);
            $table->string('name')->default('');
            $table->integer('sort')->default(0);
        });

        \Illuminate\Support\Facades\DB::table('dendrogram_adjacency')->insert([
            ["id"=>1,"p_id"=>0,"name"=>"中国"],
            ["id"=>2,"p_id"=>1,"name"=>"四川"],
            ["id"=>3,"p_id"=>1,"name"=>"北京"],
            ["id"=>4,"p_id"=>2,"name"=>"成都"],
            ["id"=>5,"p_id"=>2,"name"=>"绵阳"]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dendrogram_adjacency');
    }
}

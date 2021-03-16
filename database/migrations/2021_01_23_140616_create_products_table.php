<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("title", 100)->comments("title of the product");
            $table->string("description")->nullable();
            $table->integer("price");
            $table->string("image", 30)->nullable(); // 30 is filename length
            $table->unsignedInteger("user_id")->comments("user id no mentioned as fk");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('products');
    }
}

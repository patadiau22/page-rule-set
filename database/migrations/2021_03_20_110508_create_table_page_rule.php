<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePageRule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_rule', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('show_on')->default(1)->comment('1=> Show On, 2=> Dont show on');
            $table->tinyInteger('rule')->nullable()->comment('1=> Page that contain, 2=> a specific page, 3=>pages starting with, 4=> pages ending with');	
            $table->longText('rule_text')->nullable();
            $table->unsignedBigInteger('created_by');	
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
        Schema::dropIfExists('page_rule');
    }
}

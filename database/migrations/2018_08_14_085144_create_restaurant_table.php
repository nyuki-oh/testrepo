<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class CreateRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invalid');
            $table->string('name');
            $table->string('category_l');
            $table->string('category_view');
            $table->string('category_s');
            $table->string('category');
            $table->integer('lunch')->nullable();
            $table->integer('walking')->nullable();
            $table->float('distance')->nullable();
            $table->string('url');
            $table->timestamps();
        });
        $reader = Reader::createFromPath('./restaurant.csv');
        $reader->setHeaderOffset(0);
        $records = $reader->getRecords();
        foreach ($records as $r) {
            print_r($r);
            $ri = $r;
            if ($ri['invalid'] == '') {
                if ($ri['lunch'] == '') {
                    $ri['lunch'] = NULL;
                }
                if ($ri['walking'] == '') {
                    $ri['walking'] = NULL;
                }
                if ($ri['distance'] == '') {
                    $ri['distance'] = NULL;
                }
                DB::table('restaurant')->insert($ri);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant');
    }
}
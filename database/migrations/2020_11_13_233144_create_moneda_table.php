<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//para que funcione la clase DB para usar sql
use Illuminate\Support\Facades\DB;

class CreateMonedaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moneda', function (Blueprint $table) {
            $table->id();//autonumérico
            
            $table->string('name', 50);
            $table->string('symbol', 6);
            $table->string('zone', 80);
            $table->decimal('value', 6, 2); //con respecto al euro
            $table->date('creationdate') -> nullable(); //puede ser null
            $table->timestamps();
            
            //La pareja name-country es única.
            $table->unique(['name', 'zone']);
        });
        
        //Trigger que me convierte el campo símbolo en mayúsculas
        DB::unprepared('
            create trigger uppercaseSymbols
            before insert on moneda for each row
            set new.symbol = ucase(new.symbol)
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moneda');
    }
}

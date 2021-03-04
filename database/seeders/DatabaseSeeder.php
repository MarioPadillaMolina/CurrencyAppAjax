<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $moneda = [
            array('name' => 'Euro','symbol' => '€','zone' => 'Europe-zones','value' => '1.00','creationdate' => '1999-01-02'),
            array('name' => 'Dollar','symbol' => '$','zone' => 'United States','value' => '0.86','creationdate' => '1786-01-01'),
            array('name' => 'Pound','symbol' => 'GBP','zone' => 'Great Britain','value' => '1.11','creationdate' => '1820-01-01'),
            array('name' => 'Peso','symbol' => 'CUP','zone' => 'Cuba','value' => '0.03','creationdate' => '1768-07-05'),
            array('name' => 'Dirham','symbol' => 'MAD','zone' => 'Morocco','value' => '0.09','creationdate' => '1895-05-01'),
            array('name' => 'Yen','symbol' => 'JPY','zone' => 'Japan','value' => '0.01','creationdate' => '1745-06-05'),
            array('name' => 'Peso','symbol' => 'ARS','zone' => 'Argentina','value' => '0.01','creationdate' => '1685-04-05'),
            array('name' => 'Dollar','symbol' => '$','zone' => 'Brunei','value' => '0.63','creationdate' => '1942-04-02'),
            array('name' => 'Dollar','symbol' => 'CAD','zone' => 'Canada','value' => '0.64','creationdate' => '1854-03-05'),
            array('name' => 'rublo','symbol' => 'RBL','zone' => 'Rusia','value' => '0.30','creationdate' => '2020-11-12'),
        ];
        
        $moneda2 = [
            ['name' => 'Euro','symbol' => '€','zone' => 'Europe-zones','value' => 1.00,'creationdate' => '1999-01-02'],
            ['name' => 'Dollar','symbol' => '$','zone' => 'United States','value' => 0.86,'creationdate' => '1786-01-01'],
            ['name' => 'Pound','symbol' => 'GBP','zone' => 'Great Britain','value' => 1.11,'creationdate' => '1820-01-01'],
            ['name' => 'Peso','symbol' => 'CUP','zone' => 'Cuba','value' => 0.03,'creationdate' => '1768-07-05'],
            ['name' => 'Dirham','symbol' => 'MAD','zone' => 'Morocco','value' => 0.09,'creationdate' => '1895-05-01'],
            ['name' => 'Yen','symbol' => 'JPY','zone' => 'Japan','value' => 0.01,'creationdate' => '1745-06-05'],
            ['name' => 'Peso','symbol' => 'ARS','zone' => 'Argentina','value' => 0.01,'creationdate' => '1685-04-05'],
            ['name' => 'Dollar','symbol' => '$','zone' => 'Brunei','value' => 0.63,'creationdate' => '1942-04-02'],
            ['name' => 'Dollar','symbol' => 'CAD','zone' => 'Canada','value' => 0.64,'creationdate' => '1854-03-05'],
            ['name' => 'rublo','symbol' => 'RBL','zone' => 'Rusia','value' => 0.30,'creationdate' => '2020-11-12']
            ];
            
        DB::table('moneda')->insert($moneda);
    }
}

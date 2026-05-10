<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiendaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('linea_ventas')->delete();
        DB::table('pagos')->delete();
        DB::table('ventas')->delete();
        DB::table('producto')->delete();
        DB::table('familia')->delete();

        // familias
        DB::table('familia')->insert([
            ['tipo_familia' => 'Camisetas'],
            ['tipo_familia' => 'Pantalones'],
        ]);

        $familias = DB::table('familia')->pluck('id_familia')->all();

        // productos ejemplo (limpios)
        DB::table('producto')->insert([
            [
                'cantidad_stock' => 10,
                'nombre' => 'Pantalon basico',
                'precio' => 25,
                'imagen_url' => 'https://www.forumsport.com/images/castore-pantalones-futbol-oficiales-nino-athlbilbao-26-home-inf-short-vista-frontal-1001048701-1000x1000-f',
                'descripcion' => 'Pantalon principal',
                'id_familia' => $familias[1] ?? 2,
            ],
            [
                'cantidad_stock' => 8,
                'nombre' => 'Camiseta azul',
                'precio' => 65,
                'imagen_url' => 'https://static.futbolfactory.es/products/254253_1.webp',
                'descripcion' => 'Segunda camiseta',
                'id_familia' => $familias[0] ?? 1,
            ],
        ]);
    }
}

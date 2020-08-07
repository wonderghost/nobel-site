<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class sectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $arr = [
            "Metiers",
            "Services",
            "Paiements",
            "Canaux de distributions",
            'Plateforme',
            'Cas Pratiques',
            'Creer un compte',
            'Contact',
            'A Propos'
        ];

        $par = [
            true,
            true,
            true,
            true,
            true,
            false,
            false,
            false,
            true     
        ];

        for($i = 0 ; $i < count($arr) ; $i++) {

            DB::table('sections')->insert([
                'slug'  =>  Str::slug($arr[$i]),
                'title' =>  $arr[$i],
                'description'   =>  '',
                'parent'    =>  $par[$i]
            ]);
        }

        // DB::table('sections')->insert([
        //     'slug'  =>  Str::slug('A propos'),
        //     'title' =>  'A propos',
        //     'description'   =>  '',
        //     'parent'    =>  true
        // ]);

    }
}

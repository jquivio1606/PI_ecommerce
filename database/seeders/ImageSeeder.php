<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    public function run()
    {
        $images = [
            // 1. Abrigo largo mujer camel
            ['product_id' => 1, 'url' => 'fotos_productos/abrigo_largo_muj_camel_1.png'],
            ['product_id' => 1, 'url' => 'fotos_productos/abrigo_largo_muj_camel.png'],

            // 2. Blazer hombre negro
            ['product_id' => 2, 'url' => 'fotos_productos/blazer_hom_negro_1.png'],
            ['product_id' => 2, 'url' => 'fotos_productos/blazer_hom_negro.png'],

            // 3. Botas
            ['product_id' => 3, 'url' => 'fotos_productos/botas_altas_muj_negro.jpg'],
            ['product_id' => 4, 'url' => 'fotos_productos/botas_montaña_uni_marron.png'],

            // 4. Camisa lino hombre blanco
            ['product_id' => 5, 'url' => 'fotos_productos/camisa_lino_hom_blanco.png'],

            // 5. Camiseta algodón unisex rojo
            ['product_id' => 6, 'url' => 'fotos_productos/camiseta_alg_uni_rojo_1.jpg'],
            ['product_id' => 6, 'url' => 'fotos_productos/camiseta_alg_uni_rojo_2.jpg'],
            ['product_id' => 6, 'url' => 'fotos_productos/camiseta_alg_uni_rojo.jpg'],

            // 6. Camiseta V unisex blanco
            ['product_id' => 7, 'url' => 'fotos_productos/camiseta_v_uni_blanco_1.png'],
            ['product_id' => 7, 'url' => 'fotos_productos/camiseta_v_uni_blanco_2.png'],
            ['product_id' => 7, 'url' => 'fotos_productos/camiseta_v_uni_blanco.png'],

            // 7. Camiseta rayas mujer blanco
            ['product_id' => 8, 'url' => 'fotos_productos/camiseta_rayas_muj_blanco_1.jpg'],
            ['product_id' => 8, 'url' => 'fotos_productos/camiseta_rayas_muj_blanco.jpg'],

            // 8. Chaqueta cuero hombre negro
            ['product_id' => 9, 'url' => 'fotos_productos/chaqueta_cuero_hom_negro.jpg'],

            // 9. Chaqueta lana mujer gris
            ['product_id' => 10, 'url' => 'fotos_productos/chaqueta_lana_muj_gris_1.jpg'],
            ['product_id' => 10, 'url' => 'fotos_productos/chaqueta_lana_muj_gris_2.jpg'],
            ['product_id' => 10, 'url' => 'fotos_productos/chaqueta_lana_muj_gris.jpg'],

            // 10. Chaqueta lluvia unisex azul
            ['product_id' => 11, 'url' => 'fotos_productos/chaqueta_lluvia_uni_azul_1.png'],
            ['product_id' => 11, 'url' => 'fotos_productos/chaqueta_lluvia_uni_azul.png'],

            // 11. Conjunto mujer beige
            ['product_id' => 12, 'url' => 'fotos_productos/conjunto_muj_beige_1.png'],
            ['product_id' => 12, 'url' => 'fotos_productos/conjunto_muj_beige_2.png'],
            ['product_id' => 12, 'url' => 'fotos_productos/conjunto_muj_beige.png'],

            // 12. Conjunto deporte unisex verde
            ['product_id' => 13, 'url' => 'fotos_productos/conjunto_deporte_uni_verde_1.png'],
            ['product_id' => 13, 'url' => 'fotos_productos/conjunto_deporte_uni_verde.png'],

            // 13. Chaleco formal hombre gris
            ['product_id' => 14, 'url' => 'fotos_productos/chaleco_formal_hom_gris.png'],

            // 14. Conjunto formal hombre gris
            ['product_id' => 15, 'url' => 'fotos_productos/conjunto_formal_hom_gris_1.png'],
            ['product_id' => 15, 'url' => 'fotos_productos/conjunto_formal_hom_gris_2.png'],
            ['product_id' => 15, 'url' => 'fotos_productos/conjunto_formal_hom_gris.png'],

            // 15. Falda larga mujer beige
            ['product_id' => 16, 'url' => 'fotos_productos/falda_larga_muj_beige_1.jpg'],
            ['product_id' => 16, 'url' => 'fotos_productos/falda_larga_muj_beige.jpg'],

            // 16. Falda floral mujer rosa
            ['product_id' => 17, 'url' => 'fotos_productos/falda_floral_muj_rosa.png'],

            // 17. Jersey grueso mujer gris
            ['product_id' => 18, 'url' => 'fotos_productos/jersey_grueso_muj_gris.png'],

            // 18. Jersey fino unisex beige
            ['product_id' => 19, 'url' => 'fotos_productos/jersey_fino_uni_beige_1.png'],
            ['product_id' => 19, 'url' => 'fotos_productos/jersey_fino_uni_beige.png'],

            // 19. Pantalon cargo unisex gris
            ['product_id' => 20, 'url' => 'fotos_productos/pantalon_cargo_uni_gris_1.png'],
            ['product_id' => 20, 'url' => 'fotos_productos/pantalon_cargo_uni_gris_2.png'],
            ['product_id' => 20, 'url' => 'fotos_productos/pantalon_cargo_uni_gris.png'],

            // 20. Pantalon deporte hombre azul
            ['product_id' => 21, 'url' => 'fotos_productos/pantalon_depor_hom_azul_1.jpg'],
            ['product_id' => 21, 'url' => 'fotos_productos/pantalon_depor_hom_azul.jpg'],

            // 21. Pantalon formal hombre negro
            ['product_id' => 22, 'url' => 'fotos_productos/pantalon_formal_hom_negro_1.jpg'],
            ['product_id' => 22, 'url' => 'fotos_productos/pantalon_formal_hom_negro_2.jpg'],
            ['product_id' => 22, 'url' => 'fotos_productos/pantalon_formal_hom_negro.jpg'],

            // 22. Pantalon palazzo mujer negro
            ['product_id' => 23, 'url' => 'fotos_productos/pantalon_palazzo_muj_negro_1.png'],
            ['product_id' => 23, 'url' => 'fotos_productos/pantalon_palazzo_muj_negro.png'],

            // 23. Pantalon corto unisex azul
            ['product_id' => 24, 'url' => 'fotos_productos/pantalon_corto_uni_azul.png'],

            // 24. Sandalias mujer marrón
            ['product_id' => 25, 'url' => 'fotos_productos/sandalias_muj_marron.png'],

            // 25. Sudadera hombre blanca
            ['product_id' => 26, 'url' => 'fotos_productos/sudadera_hom_blanca_1.png'],
            ['product_id' => 26, 'url' => 'fotos_productos/sudadera_hom_blanca.png'],

            // 26. Sudadera oversize unisex gris
            ['product_id' => 27, 'url' => 'fotos_productos/sudadera_oversize_uni_gris_1.png'],
            ['product_id' => 27, 'url' => 'fotos_productos/sudadera_oversize_uni_gris.png'],

            // 27. Conjunto urbano unisex negro
            ['product_id' => 28, 'url' => 'fotos_productos/conjunto_urbano_uni_negro_1.png'],
            ['product_id' => 28, 'url' => 'fotos_productos/conjunto_urbano_uni_negro.png'],

            // 28. Vestido corto mujer azul
            ['product_id' => 29, 'url' => 'fotos_productos/vestido_corto_muj_azul.jpg'],

            // 29. Vestido marinero mujer blanco
            ['product_id' => 30, 'url' => 'fotos_productos/vestido_marinero_muj_blanco.png'],

            // 30. Vestido playa mujer blanco
            ['product_id' => 31, 'url' => 'fotos_productos/vestido_playa_muj_blanco.png'],

            // 31. Vestido largo mujer beige y turquesa
            ['product_id' => 32, 'url' => 'fotos_productos/vestido_largo_muj_beige_1.jpg'],
            ['product_id' => 33, 'url' => 'fotos_productos/vestido_largo_muj_turquesa_1.jpg'],
            ['product_id' => 33, 'url' => 'fotos_productos/vestido_largo_muj_turquesa.jpg'],

            // 32. Zapatos formal unisex negro
            ['product_id' => 34, 'url' => 'fotos_productos/zapatos_formal_uni_negro_1.jpg'],
            ['product_id' => 34, 'url' => 'fotos_productos/zapatos_formal_uni_negro.jpg'],

            // 33. Zapatos deporte unisex blanco
            ['product_id' => 35, 'url' => 'fotos_productos/zapatos_depor_uni_blanco.jpg'],

            // 34. Zapatos casual unisex naranja
            ['product_id' => 36, 'url' => 'app/public/fotos_productos/zapatos_casual_uni_naranja.png'],
        ];

        foreach ($images as $img) {
            Image::create([
                'product_id' => $img['product_id'],
                'url' => $img['url'],

            ]);
        }
    }
}

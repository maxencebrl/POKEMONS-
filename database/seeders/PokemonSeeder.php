<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pokemon;

class PokemonSeeder extends Seeder
{
    public function run(): void
    {
        // genre : 1 = femelle, 0 = mâle   |   is_shiny : 1 = shiny, 0 = normal
        // Remplace chaque COLLE_LE_LIEN_ICI par le lien de l'image du Pokémon.
        $pokemons = [
            ['name' => 'Salamèche',  'height' => 0.6, 'weight' => 8.5,   'life' => 70,  'genre' => 0, 'captured_at' => '2026-10-17', 'level' => 15,  'image' => 'https://tse1.explicit.bing.net/th/id/OIP.PEbl3cMTUkjsP-Kz4L5MSgAAAA?r=0&pid=ImgDet&w=178&h=178&c=7&dpr=1,5&o=7&rm=3', 'is_shiny' => 1],
            
            ['name' => 'Carapuce',   'height' => 0.5, 'weight' => 9,     'life' => 75,  'genre' => 1, 'captured_at' => '2026-10-17', 'level' => 16,  'image' => 'https://tse4.mm.bing.net/th/id/OIP.m5WLtGdufnbmjov5t_Ik_AAAAA?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 'is_shiny' => 0],
            
            ['name' => 'Herbizarre', 'height' => 1.0, 'weight' => 13,    'life' => 95,  'genre' => 0, 'captured_at' => '2026-10-18', 'level' => 28,  'image' => 'https://i.pinimg.com/474x/1c/51/61/1c5161195d71d2e33858ce1256669053.jpg', 'is_shiny' => 0],
            
            ['name' => 'Reptincel',  'height' => 1.1, 'weight' => 19,    'life' => 105, 'genre' => 0, 'captured_at' => '2026-10-18', 'level' => 32,  'image' => 'https://www.pokemonunite.gg/res/img/pkmn/005.png', 'is_shiny' => 1],
            
            ['name' => 'Carabaffe',  'height' => 1.0, 'weight' => 22.5,  'life' => 110, 'genre' => 1, 'captured_at' => '2026-10-18', 'level' => 34,  'image' => 'https://m.media-amazon.com/images/I/81hSwPi5qTL.png', 'is_shiny' => 0],
            
            ['name' => 'Évoli',      'height' => 0.3, 'weight' => 6.5,   'life' => 65,  'genre' => 1, 'captured_at' => '2026-10-19', 'level' => 12,  'image' => 'https://tse2.mm.bing.net/th/id/OIP.D2WPKNxKPJ7Ls-84KJultQHaGN?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 'is_shiny' => 1],
            
            ['name' => 'Mewtwo',     'height' => 2.0, 'weight' => 122,   'life' => 250, 'genre' => 0, 'captured_at' => '2026-10-19', 'level' => 100, 'image' => 'https://pbs.twimg.com/media/FHTZJjlVQAMeM1U.jpg', 'is_shiny' => 0],
            
            ['name' => 'Mew',        'height' => 0.4, 'weight' => 4,     'life' => 220, 'genre' => 1, 'captured_at' => '2026-10-19', 'level' => 95,  'image' => 'https://th.bing.com/th/id/OIP.xZHgNIFKrWE-XYtinpPQEwHaEJ?w=296&h=180&c=7&r=0&o=7&dpr=1.5&pid=1.7&rm=3', 'is_shiny' => 1],
            
            ['name' => 'Gengar',     'height' => 1.5, 'weight' => 40.5,  'life' => 130, 'genre' => 0, 'captured_at' => '2026-10-20', 'level' => 55,  'image' => 'https://tse2.mm.bing.net/th/id/OIP.laoCQryuf7PYulY0A4OukAHaHU?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 'is_shiny' => 0],
            
            ['name' => 'Dracolosse', 'height' => 2.2, 'weight' => 210,   'life' => 200, 'genre' => 0, 'captured_at' => '2026-10-20', 'level' => 78,  'image' => 'https://www.dexerto.fr/cdn-image/wp-content/uploads/sites/2/2024/02/12/dracolosse-pokemon-go-arene-fan-1024x576.jpg?width=1200&quality=75&format=auto', 'is_shiny' => 0],
            
            ['name' => 'Léviator',   'height' => 6.5, 'weight' => 235,   'life' => 190, 'genre' => 1, 'captured_at' => '2026-10-20', 'level' => 70,  'image' => 'https://www.pokemoncenter.com/images/DAMRoot/Thumbnail/10000/P4830_701-03757_01.jpg', 'is_shiny' => 1],
            
            ['name' => 'Arcanin',    'height' => 1.9, 'weight' => 155,   'life' => 180, 'genre' => 0, 'captured_at' => '2026-10-21', 'level' => 66,  'image' => 'https://www.pokepedia.fr/images/thumb/7/7e/Arcanin-RFVF.png/240px-Arcanin-RFVF.png', 'is_shiny' => 0],
            
            ['name' => 'Lokhlass',   'height' => 2.5, 'weight' => 220,   'life' => 195, 'genre' => 1, 'captured_at' => '2026-10-21', 'level' => 60,  'image' => 'https://repaireduphenix.com/cdn/shop/files/1761940651133-c2x7t3s20ml_b851e5f4-9325-489c-b340-c5d43527e951.jpg?v=1767170880&width=800', 'is_shiny' => 0],
            
            ['name' => 'Ptéra',      'height' => 1.8, 'weight' => 59,    'life' => 150, 'genre' => 0, 'captured_at' => '2026-10-21', 'level' => 50,  'image' => 'https://th.bing.com/th/id/OIP.5s7VKTeRWCNXvuQ76EjPnwHaEl?w=289&h=180&c=7&r=0&o=7&dpr=1.5&pid=1.7&rm=3', 'is_shiny' => 0],
            
            ['name' => 'Alakazam',   'height' => 1.5, 'weight' => 48,    'life' => 120, 'genre' => 0, 'captured_at' => '2026-10-22', 'level' => 62,  'image' => 'https://tse2.mm.bing.net/th/id/OIP.EoFOxLkmOjscVg1mjKCz3wAAAA?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 'is_shiny' => 0],
            
            ['name' => 'Mackogneur', 'height' => 1.6, 'weight' => 130,   'life' => 175, 'genre' => 0, 'captured_at' => '2026-10-22', 'level' => 58,  'image' => 'https://www.pokepedia.fr/images/thumb/c/ce/Mackogneur_de_Giovanni.png/600px-Mackogneur_de_Giovanni.png', 'is_shiny' => 0],
            
            ['name' => 'Magicarpe',  'height' => 0.9, 'weight' => 10,    'life' => 50,  'genre' => 1, 'captured_at' => '2026-10-22', 'level' => 5,   'image' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/08d32e88-ab43-4498-9211-470801c90b77-profile_image-300x300.png', 'is_shiny' => 1],
            
            ['name' => 'Psykokwak',  'height' => 0.8, 'weight' => 19.6,  'life' => 90,  'genre' => 1, 'captured_at' => '2026-10-23', 'level' => 20,  'image' => 'https://i.pinimg.com/originals/16/72/64/167264f9441686c19936028e39838a20.jpg', 'is_shiny' => 0],
            
            ['name' => 'Rondoudou',  'height' => 0.5, 'weight' => 5.5,   'life' => 115, 'genre' => 1, 'captured_at' => '2026-10-23', 'level' => 25,  'image' => 'https://comicvine.gamespot.com/a/uploads/original/11112/111122518/5177131-trigg.png', 'is_shiny' => 0],
            
            ['name' => 'Miaouss',    'height' => 0.4, 'weight' => 4.2,   'life' => 60,  'genre' => 0, 'captured_at' => '2026-10-23', 'level' => 14,  'image' => 'https://th.bing.com/th/id/OIP.UY1NDJHS-Hd7XAKQMkXkrQHaEG?w=315&h=180&c=7&r=0&o=7&dpr=1.5&pid=1.7&rm=3', 'is_shiny' => 0],
            
            ['name' => 'Abra',       'height' => 0.9, 'weight' => 19.5,  'life' => 55,  'genre' => 0, 'captured_at' => '2026-10-24', 'level' => 18,  'image' => 'https://i.pinimg.com/736x/96/bf/02/96bf025ac680a38c7ae588b332d80a87.jpg', 'is_shiny' => 0],
            
            ['name' => 'Nidoking',   'height' => 1.4, 'weight' => 62,    'life' => 140, 'genre' => 0, 'captured_at' => '2026-10-24', 'level' => 52,  'image' => 'https://i.imgflip.com/2/9zlnth.jpg', 'is_shiny' => 0],
            
            ['name' => 'Nidoqueen',  'height' => 1.3, 'weight' => 60,    'life' => 145, 'genre' => 1, 'captured_at' => '2026-10-24', 'level' => 53,  'image' => 'https://th.bing.com/th/id/OIP.faMnl8FMeXJVnXWD_qKdKAAAAA?w=202&h=202&c=7&r=0&o=7&dpr=1.5&pid=1.7&rm=3', 'is_shiny' => 0],
            
            ['name' => 'Fantominus', 'height' => 1.3, 'weight' => 0.1,   'life' => 70,  'genre' => 0, 'captured_at' => '2026-10-25', 'level' => 22,  'image' => 'https://wallpapers-base.com/wp-content/uploads/2018/08/high_quality_wallpaper_HD_1080_IDS_1063161-768x768-optimized.jpg', 'is_shiny' => 0],
            
            ['name' => 'Onix',       'height' => 8.8, 'weight' => 210,   'life' => 125, 'genre' => 0, 'captured_at' => '2026-10-25', 'level' => 40,  'image' => 'https://i.pinimg.com/736x/d8/a2/35/d8a235b416e25912a368823e285fb6e5--pokemon-puns-pokemon-moon.jpg', 'is_shiny' => 0],
            
            ['name' => 'Électrode',  'height' => 1.2, 'weight' => 66.6,  'life' => 110, 'genre' => 0, 'captured_at' => '2026-10-25', 'level' => 45,  'image' => 'https://img.ifunny.co/images/9e8385b82aa8a96226f17cedf509685c5829ed77f26d24c09694eb1453974abf_1.jpg', 'is_shiny' => 1],
            
            
            ['name' => 'Aquali',     'height' => 1.0, 'weight' => 29,    'life' => 150, 'genre' => 1, 'captured_at' => '2026-10-27', 'level' => 44,  'image' => 'https://tse1.explicit.bing.net/th/id/OIP.I9icWUrLlLAOxukZiLQ2rQHaFk?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 'is_shiny' => 1],
        ];


        foreach ($pokemons as $pokemon) {
            // updateOrCreate : si le Pokémon existe déjà (même nom), il est mis à jour au lieu d'être dupliqué
            Pokemon::updateOrCreate(['name' => $pokemon['name']], $pokemon);
        }
    }
}
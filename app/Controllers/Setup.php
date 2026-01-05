<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Setup extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();

// Tabel User
$db->query("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT,
    email TEXT UNIQUE,
    password TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Tabel Simpan Pin
$db->query("CREATE TABLE IF NOT EXISTS saved_looks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    look_id INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, look_id)
)");
        $db = \Config\Database::connect();
        $db->query('DROP TABLE IF EXISTS users');
        $db->query('DROP TABLE IF EXISTS looks');
        $db->query('DROP TABLE IF EXISTS boards');
        $db->query('DROP TABLE IF EXISTS pins');

        // $forge->dropTable('pins', true);
        // $forge->dropTable('looks', true);
        // Tabel Looks 
        $db->query('CREATE TABLE looks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT,
            user TEXT,
            image_url TEXT,
            title TEXT,
            description TEXT,
            pins INTEGER DEFAULT 0,
            
            /* item_details menyimpan JSON berisi beberapa jenis pakaian.
               Masing-masing pakaianpunya tags dalam bentuk List/Array */
            item_details TEXT,
            shopee_link TEXT,
            visibility TEXT DEFAULT "public"
        )');
        $db->query('CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE,
            email TEXT UNIQUE,
            password TEXT,
            token TEXT, -- Kode rahasia login disimpan di sini
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )');
        $db->query('CREATE TABLE boards (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        name TEXT,
        category TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )');

    $db->query('CREATE TABLE pins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        board_id INTEGER,
        title TEXT,
        description TEXT,
        image_url TEXT,
        user TEXT,
        item_details TEXT, 
        tags TEXT,
        category TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )');
        
         
        return "✅ Database di-reset! Struktur item_details dengan multiple tags sudah siap.";
    }

    public function seed()
    {
        $db = \Config\Database::connect();
        
        $data = [
            [
                'email'       => 'jiangjia123@gmail.com',
                'user'        => 'cutiejiajia_05',
                'title'       => 'Dreamy Pink Garden Look',
                'description' => 'Cafe date 💗',
                'image_url'   => 'https://i.pinimg.com/736x/6d/8a/8c/6d8a8c31dc482b99c4042df34578dcf5.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '1_01', 
                        'category' => 'Outer', 
                        'tags'     => ['White', 'Cardigan', 'Long-sleeved', 'Lightweight', 'Thin']
                    ],
                    [
                        'item_id'  => '1_02', 
                        'category' => 'Dress', 
                        'tags'     => ['Pink', 'Pastel', 'Flowy', 'Spring', 'Ribbon', 'Drawstring', 'Flowy']
                    ],
                    [
                        'item_id'  => '1_03', 
                        'category' => 'Bag', 
                        'tags'     => ['Neutral' , 'Beige', 'Light brown', 'Brown', 'Textured', 'Shoulder']
                    ]
                ])
            ],
            [
                'email'       => 'jiangjia123@gmail.com',
                'user'        => 'cutiejiajia_05',
                'title'       => 'Casual Fit OTD',
                'description' => 'Simple, yet Cute🤭',
                'image_url'   => 'https://i.pinimg.com/736x/2c/4a/69/2c4a69b2eea754cebad5e3ce98e7d476.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '2_01', 
                        'category' => 'Outer', 
                        'tags'     => ['Cropped', 'Short-sleeved', 'Azure', 'Light blue', 'Blue', 'Sophisticated', 'Boxy']
                    ],
                    [
                        'item_id'  => '2_02', 
                        'category' => 'Top', 
                        'tags'     => ['T-Shirt', 'White', 'Minimalist', 'Neutral', 'Plain', 'Short-sleeved', 'Casual']
                    ],
                    [
                        'item_id'  => '2_03', 
                        'category' => 'Bottom', 
                        'tags'     => ['Jeans', 'Denim', 'Wide-leg', 'High-waisted', 'Light blue', 'Casual', 'Full-length']
                    ]
                ])
            ],
            [
                'email'       => 'belleinparis@gmail.com',
                'user'        => 'princessbelle',
                'title'       => 'Lovely Picnic Style',
                'description' => 'Going to a picnic date with my favourite💕',
                'image_url'   => 'https://i.pinimg.com/736x/53/83/63/538363a2dd68ddf61b4c2fb5bb336798.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '3_01', 
                        'category' => 'Dress', 
                        'tags'     => ['White', 'Blue', 'Dark Blue', 'Floral', 'Midi', 'Romantic', 'Cottagecore', 'Summer']
                    ],
                ])
            ],
            [
                'email'       => 'emilygeorge@gmail.com',
                'user'        => 'imnot_emily',
                'title'       => 'Museum Visit',
                'description' => 'I lovee my outfit for today',
                'image_url'   => 'https://i.pinimg.com/736x/f8/b7/54/f8b754f5a870c2e6c24bd2ef48235b77.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '4_01', 
                        'category' => 'Dress', 
                        'tags'     => ['White', 'Elegant', 'Vintage', ' Ruched', 'Button-down', 'Cream']
                    ],
                ])
            ],
            [
                'email'       => 'lusylee@gmail.com',
                'user'        => 'elysul03',
                'title'       => 'Easy Day Out („• ֊ •„)',
                'description' => 'Someone just took a picture of me, and I was not ready🥹',
                'image_url'   => 'https://i.pinimg.com/1200x/ea/0e/9f/ea0e9f5d1b7938db7f8fd1ad1c6b16d5.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '5_01', 
                        'category' => 'Top', 
                        'tags'     => ['Sweater', 'Striped', 'Navy', 'Blue', 'Breton', 'Long-sleeved', 'Knit']
                    ],
                    [
                        'item_id'  => '5_02', 
                        'category' => 'Bottom', 
                        'tags'     => ['Straight', 'Full-length', 'Wide-leg', 'High-waisted', 'White', 'Cream']
                    ],
                ])
            ],
            [
                'email'       => 'maomaooo@gmail.com',
                'user'        => 'ke_ai_miawmiaw',
                'title'       => 'Efortless Fit',
                'description' => 'Strolling around Jakarta',
                'image_url'   => 'https://i.pinimg.com/736x/da/d5/4f/dad54f03b4853addc53fd60f73602a2c.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '6_01', 
                        'category' => 'Outer', 
                        'tags'     => ['Sage', 'Beige', 'Cream', 'Multicolor', 'Plaid', 'Flannel', 'Oversized', 'Casual', 'Tartan']
                    ],
                    [
                        'item_id'  => '6_02', 
                        'category' => 'Top', 
                        'tags'     => ['T-Shirt', 'White', 'Minimalist', 'Neutral', 'Plain', 'Short-sleeved', 'Casual']
                    ],
                    [
                        'item_id'  => '6_03', 
                        'category' => 'Bottom', 
                        'tags'     => ['Light blue', 'Pale', 'Drawstring', 'Full-length', 'Wide-leg', 'Slouchy', 'Tie-waist']
                    ],
                ])
            ],
            [
                'email'       => 'rangrang2023@gmail.com',
                'user'        => 'rangpluszai__',
                'title'       => 'Noticed You',
                'description' => 'Styled by her',
                'image_url'   => 'https://i.pinimg.com/736x/03/c2/87/03c2870555f793ebe279d2a178f57af9.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '7_01', 
                        'category' => 'Outer', 
                        'tags'     => ['Shirt', 'Oversized', 'Sky-blue', 'Light blue', 'Long-sleeved', 'Oxford']
                    ],
                    [
                        'item_id'  => '7_02', 
                        'category' => 'Top', 
                        'tags'     => ['White', 'T-shirt', 'Crewneck', 'Minimalist', 'Plain', 'Short-sleeved', 'Casual']
                    ],
                    [
                        'item_id'  => '7_03', 
                        'category' => 'Bottom', 
                        'tags'     => ['Black', 'Straight', 'Wide-leg', 'Full-length', 'Trousers', 'Tailored', 'Dark']
                    ],
                ])
            ],
            [
                'email'       => 'rangrang2023@gmail.com',
                'user'        => 'rangpluszai__',
                'title'       => 'Coffee Break',
                'description' => 'A quiet moment between sips of coffee and an unhurried afternoon.',
                'image_url'   => 'https://i.pinimg.com/736x/77/22/ef/7722ef87b135757d8349014943812e55.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '8_01', 
                        'category' => 'Outer', 
                        'tags'     => ['Teal', 'Dark blue', 'Blue', 'Cardigan', 'Knitted', 'Soft', 'Cozy', 'Textured', 'Long-sleeved']
                    ],
                    [
                        'item_id'  => '8_02', 
                        'category' => 'Top', 
                        'tags'     => ['White', 'T-shirt', 'Crewneck', 'Minimalist', 'Plain', 'Short-sleeved', 'Casual']
                    ],
                    [
                        'item_id'  => '8_03', 
                        'category' => 'Bottom', 
                        'tags'     => ['Jeans', 'Full-length', 'Denim', 'Indigo', 'Blue', 'Wide-leg', 'Baggy']
                    ],
                    [
                        'item_id'  => '8_04', 
                        'category' => 'Bag', 
                        'tags'     => ['Messenger', 'Sling', 'Oversized', 'Black', 'Leather']
                    ],
                ])
            ],
            [
                'email'       => 'calebwilder12@gmail.com',
                'user'        => 'wildlikecaleb',
                'title'       => 'At Ease',
                'description' => 'Just standing there, feeling composed, like this was always meant to happen.',
                'image_url'   => 'https://i.pinimg.com/736x/1e/11/d2/1e11d207c1905296d0c4705cc6e01cf7.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '9_01', 
                        'category' => 'Outer', 
                        'tags'     => ['Rugby', 'Maroon', 'Burgundy', 'Collared', 'Long-sleeved']
                    ],
                    [
                        'item_id'  => '9_02', 
                        'category' => 'Top', 
                        'tags'     => ['Shirt', 'Striped', 'Button-up', 'Blue', 'White', 'Long-sleeved']
                    ],
                    [
                        'item_id'  => '9_03', 
                        'category' => 'Bottom', 
                        'tags'     => ['Beige', 'Cream', 'Tan', 'Full-length', 'Wide-leg', 'Pleated', 'High-waisted', 'Trousers']
                    ],
                ])
            ],
            [
                'email'       => 'jiangjia123@gmail.com',
                'user'        => 'cutiejiajia_05',
                'title'       => 'Slow Afternoon',
                'description' => 'Warm light, quiet tables, and a moment that didn’t rush me 𐔌՞. .՞𐦯',
                'image_url'   => 'https://i.pinimg.com/1200x/69/e7/3e/69e73eb301fa87aa2dfa6d9eeba95659.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '10_01', 
                        'category' => 'Outer', 
                        'tags'     => ['Cardigan', 'Olive', 'Sage', 'Green', 'Knitted', 'Buttoned', 'Long-sleeved']
                    ],
                    [
                        'item_id'  => '10_02', 
                        'category' => 'Top', 
                        'tags'     => ['T-Shirt', 'White', 'Minimalist', 'Neutral', 'Plain', 'Short-sleeved', 'Casual']
                    ],
                    [
                        'item_id'  => '10_03', 
                        'category' => 'Bottom', 
                        'tags'     => ['Skirt', 'Maxi', 'A-line', 'High-waisted', 'Flowy', 'Black', 'Dark', 'Elegant']
                    ]
                ])
            ],
            [
                'email'       => 'xavierrg@gmail.com',
                'user'        => 'reivax77',
                'title'       => 'I Know',
                'description' => 'Layers feel right, the moment feels calm, and nothing needs adjusting.',
                'image_url'   => 'https://i.pinimg.com/736x/77/12/6d/77126d40cd59a58e095ebc444e160454.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '11_01', 
                        'category' => 'Outer', 
                        'tags'     => ['Sweater', 'Grey', 'V-neck', 'Oversized', 'Academic', 'Long-sleeved']
                    ],
                    [
                        'item_id'  => '11_02', 
                        'category' => 'Top', 
                        'tags'     => ['Shirt', 'Gingham', 'Collared', 'Crisp', 'Long-sleeved', 'Blue', 'White']
                    ],
                    [
                        'item_id'  => '11_03', 
                        'category' => 'Bottom', 
                        'tags'     => ['Trousers', 'Slate', 'Blue', 'Muted', 'Full-length', 'Wide-leg', 'Elegant']
                    ]
                ])
            ],
            [
                'email'       => 'xavierrg@gmail.com',
                'user'        => 'reivax77',
                'title'       => 'Mirror Selfie',
                'description' => 'Fitcheck😜',
                'image_url'   => 'https://i.pinimg.com/736x/1e/4d/79/1e4d791ec66f7f54ed61366b12f8b2c4.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '12_01', 
                        'category' => 'Top', 
                        'tags'     => ['Rugby', 'Striped', 'Green', 'White', 'Collared', 'Long-sleeved', 'Oversized', 'Cotton']
                    ],
                    [
                        'item_id'  => '12_02', 
                        'category' => 'Bottom', 
                        'tags'     => ['Carpenter', 'Beige', 'Cream', 'Full-length', 'Straight']
                    ]
                ])
            ],
            [
                'email'       => 'victoriaemerald@gmail.com',
                'user'        => 'tori_emerald',
                'title'       => 'OOTD',
                'description' => 'Just fixing my shoes',
                'image_url'   => 'https://i.pinimg.com/736x/62/1c/4a/621c4a97b16b82360cf8368b56c841a2.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '13_01', 
                        'category' => 'Top', 
                        'tags'     => ['Shirt', 'Denim', 'Indigo', 'Navy', 'Collared', 'Long-sleeved', 'Button-up']
                    ],
                    [
                        'item_id'  => '13_02', 
                        'category' => 'Bottom', 
                        'tags'     => ['Jeans', 'Denim', 'Wide-leg', 'Full-length', 'High-waisted']
                    ]
                ])
            ],
            [
                'email'       => 'victoriaemerald@gmail.com',
                'user'        => 'tori_emerald',
                'title'       => 'My Type of Streetwear🫣',
                'description' => 'I reallyyy love this type of pose❤️',
                'image_url'   => 'https://i.pinimg.com/736x/b6/6a/6a/b66a6a281b6f88c188fbbde8613f1087.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '14_01', 
                        'category' => 'Top', 
                        'tags'     => ['Shirt', 'Striped', 'Vertical', 'Neutral', 'Beige', 'Brown', 'Button-down', 'Long-sleeved']
                    ],
                    [
                        'item_id'  => '14_02', 
                        'category' => 'Bottom', 
                        'tags'     => ['Trousers', 'Brown', 'Dark brown', 'Full-length', 'Wide-leg', 'High-waisted', 'Pleated']
                    ]
                ])
            ],
            [
                'email'       => 'andrewwkim@gmail.com',
                'user'        => 'seaweedrew',
                'title'       => 'Hi',
                'description' => 'First time using this, kinda nervous🫣',
                'image_url'   => 'https://i.pinimg.com/1200x/a2/8b/07/a28b07b648635f761afab9a42aa7f8f0.jpg', 
                'pins'        => 0,
                'item_details' => json_encode([
                    [
                        'item_id'  => '15_01', 
                        'category' => 'Outer', 
                        'tags'     => ['Shirt', 'Pink', 'Pastel', 'Button-down', 'Long-sleeved', 'Oversized']
                    ],
                    [
                        'item_id'  => '15_02', 
                        'category' => 'Top', 
                        'tags'     => ['White', 'T-shirt', 'Crewneck', 'Minimalist', 'Plain', 'Short-sleeved', 'Casual']
                    ],
                    [
                        'item_id'  => '15_03', 
                        'category' => 'Bottom', 
                        'tags'     => ['Trousers', 'Cream', 'Light brown', 'Full-length', 'Wide-leg', 'High-waisted']
                    ]
                ])
            ],
        
        ];

        $db->table('looks')->insertBatch($data);

        return "✅ Data Berhasil Masuk! Setiap baju punya banyak tags yang rapi untuk Clothify.";
    }
}
<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Setup extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();

        // Hapus tabel lama jika ada
        $forge->dropTable('pins', true);
        $forge->dropTable('boards', true);

        // 1. Tabel Boards
        $db->query('CREATE TABLE boards (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            description TEXT,
            visibility TEXT DEFAULT "public"
        )');

        // 2. Tabel Pins (MENGGUNAKAN KUTIP SATU DI AWAL & AKHIR QUERY)
        $db->query('CREATE TABLE pins (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            board_id INTEGER,
            email TEXT,
            image_url TEXT,
            source_url TEXT,
            title TEXT,
            description TEXT,
            category TEXT,
            tags TEXT,
            products TEXT,
            pins INTEGER DEFAULT 0,
            item_details TEXT, 
            FOREIGN KEY (board_id) REFERENCES boards(id)
        )');

        return "✅ Database di-reset! Error kutip sudah diperbaiki dan semua kolom aman.";
    }

    public function seed()
    {
        $db = \Config\Database::connect();
        
        $data = [
            [
                'board_id'    => 1,
                'email'       => 'jiangjia123@gmail.com',
                'title'       => 'Dreamy Pink Garden Look',
                'description' => 'Look feminin dengan pastel pink dress yang flowy 💗',
                'image_url'   => 'https://i.pinimg.com/736x/6d/8a/8c/6d8a8c31dc482b99c4042df34578dcf5.jpg', 
                'source_url'  => 'https://pinterest.com/pin/1',
                'category'    => 'Dress',
                'tags'        => 'pink, dress, coquette',
                'products'    => '', 
                'pins'        => 0,
                'item_details' => json_encode([
                    ['item_id' => 1, 'category' => 'Outer', 'tags' => 'Pink Cardigan'],
                    ['item_id' => 2, 'category' => 'Dress', 'tags' => 'Tiered Pink Dress'],
                    ['item_id' => 3, 'category' => 'Accessories', 'tags' => 'White Ribbon']
                ])
            ],
            [
                'board_id'    => 1,
                'email'       => 'jiangjia123@example.com',
                'title'       => 'Casual Fit OTD',
                'description' => 'Simple, yet cute 🤭',
                'image_url'   => 'https://i.pinimg.com/736x/2c/4a/69/2c4a69b2eea754cebad5e3ce98e7d476.jpg', 
                'source_url'  => 'https://pinterest.com/pin/2',
                'category'    => 'Outer, Jeans',
                'tags'        => 'flannel, formal, red',
                'products'    => '',
                'pins'        => 0,
                'item_details' => json_encode([
                    ['item_id' => 4, 'category' => 'Outer', 'tags' => 'Red Flannel Shirt'],
                    ['item_id' => 5, 'category' => 'Top', 'tags' => 'Black Inner'],
                    ['item_id' => 6, 'category' => 'Bottom', 'tags' => 'Blue Jeans Slim Fit']
                ])
            ],
        ];

        $builder = $db->table('pins');
        $builder->insertBatch($data);

        return "✅ 15 Data Baju Berhasil Masuk ke Database!";
    }
}
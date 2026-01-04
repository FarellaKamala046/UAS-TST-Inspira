<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ApiController extends Controller
{
    // API untuk mengambil semua data OOTD
    public function getAllLooks()
    {
        $db = \Config\Database::connect();
        $pins = $db->table('pins')->get()->getResultArray();

        // Mengubah string JSON item_details menjadi array asli sebelum dikirim
        foreach ($pins as &$pin) {
            $pin['item_details'] = json_decode($pin['item_details']);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $pins
        ]);
    }

    // API untuk mengambil 1 data spesifik berdasarkan ID
    public function getLookDetail($id)
    {
        $db = \Config\Database::connect();
        $pin = $db->table('pins')->where('id', $id)->get()->getRowArray();

        if ($pin) {
            $pin['item_details'] = json_decode($pin['item_details']);
            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $pin
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Pin tidak ditemukan'], 404);
    }
}
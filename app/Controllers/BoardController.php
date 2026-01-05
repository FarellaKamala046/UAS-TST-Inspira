<?php

namespace App\Controllers;

use App\Models\BoardModel;
use App\Models\PinModel;
use CodeIgniter\RESTful\ResourceController;

class BoardController extends ResourceController
{
    protected $modelName = 'App\Models\BoardModel';
    protected $format    = 'json';

    // Endpoint 1: Create Board (POST /boards)
    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Board created!']);
        }
        return $this->fail('Gagal membuat board.');
    }

    // Endpoint 2: List My Boards (GET /boards)
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // Endpoint 3: Add Pin to Board (POST /boards/{boardId}/pins)
    public function addLook($boardId = null)
    {
        $pinModel = new \App\Models\PinModel();
        $data = $this->request->getJSON(true);
        $data['board_id'] = $boardId; // Hubungkan pin dengan ID board-nya

        // Karena tags dan products itu bentuknya array di JSON, 
        // kita ubah jadi string agar bisa masuk ke database SQLite
        if(isset($data['tags'])) $data['tags'] = json_encode($data['tags']);
        if(isset($data['products'])) $data['products'] = json_encode($data['products']);

        if ($pinModel->insert($data)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Pin added to board!']);
        }
        return $this->fail('Gagal menambah pin.');
    }

    // Endpoint 4: Get Board Detail with Pins (GET /boards/{boardId})
    public function show($id = null)
    {
        $board = $this->model->find($id);
        if (!$board) return $this->failNotFound('Board tidak ketemu');

        $pinModel = new \App\Models\PinModel();
        $board['pins'] = $pinModel->where('board_id', $id)->findAll();

        return $this->respond($board);
    }

    // Endpoint 5: Filter Boards by Tag + Category
    public function searchBoards()
    {
        $tag = $this->request->getVar('tags');
        $category = $this->request->getVar('category');

        $builder = $this->model->builder();
        $builder->select('boards.*');
        $builder->join('pins', 'pins.board_id = boards.id');

        if ($tag) {
            $builder->like('pins.tags', $tag);
        }
        if ($category) {
            $builder->where('pins.category', $category);
        }
        $builder->groupBy('boards.id');
        
        $data = $builder->get()->getResult();
        return $this->respond($data);
    }

    // Endpoint 6: Filter Pins by Tag + Category (untuk Feed Explore)
    public function searchLooks()
    {
        $pinModel = new \App\Models\PinModel();
        $tag = $this->request->getVar('tags');
        $category = $this->request->getVar('category');

        $builder = $pinModel->builder();

        if ($tag) {
            $builder->like('tags', $tag);
        }
        if ($category) {
            $builder->where('category', $category);
        }

        $data = $builder->get()->getResult();
        return $this->respond($data);
    }

    // Endpoint 7: Get All Pins for Profile (GET /api/my-saved/{userId})
    public function getSaved($userId = null)
    {
        $pinModel = new \App\Models\PinModel();
        
        $builder = $pinModel->builder();
        $builder->select('pins.*');
        $builder->join('boards', 'boards.id = pins.board_id');
        $builder->where('boards.user_id', $userId);
        
        $data = $builder->get()->getResult();

        return $this->respond([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    // --- TAMBAHAN BARU UNTUK FITUR SIMPAN OTOMATIS ---
    // Endpoint 8: Quick Save (POST /api/quick-save)
    public function quickSave()
    {
        $json = $this->request->getJSON(true);
        $userId = $json['user_id'];
        $lookData = $json['look_data'];

        $db = \Config\Database::connect();

        // Cari atau buat board default "My Saves" untuk user ini
        $board = $db->table('boards')->where(['user_id' => $userId, 'name' => 'My Saves'])->get()->getRowArray();

        if (!$board) {
            $db->table('boards')->insert([
                'user_id' => $userId,
                'name'    => 'My Saves',
                'category' => 'General'
            ]);
            $boardId = $db->insertID();
        } else {
            $boardId = $board['id'];
        }

        $pinModel = new \App\Models\PinModel();
        $lookData['board_id'] = $boardId;
        
        if(isset($lookData['tags'])) $lookData['tags'] = json_encode($lookData['tags']);
        if(isset($lookData['products'])) $lookData['products'] = json_encode($lookData['products']);

        if ($pinModel->insert($lookData)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Berhasil disimpan!']);
        }
        return $this->fail('Gagal menyimpan.');
    }
}
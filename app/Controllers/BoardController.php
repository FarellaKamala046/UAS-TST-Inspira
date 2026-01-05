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
    public function deletePin($id = null) {
    $pinModel = new \App\Models\PinModel();
    if ($pinModel->delete($id)) {
        return $this->respondDeleted(['status' => 'success', 'message' => 'Pin berhasil dihapus']);
    }
    return $this->fail('Gagal menghapus pin');
    }

    // Endpoint 8: Quick Save (POST /api/quick-save)
    public function quickSave()
    {
        $json = $this->request->getJSON(true);
        $userId = $json['user_id'];
        $look = $json['look_data'];

        $db = \Config\Database::connect();

        // 1. Cari atau buat board default "My Saves"
        $board = $db->table('boards')->where(['user_id' => $userId, 'name' => 'My Saves'])->get()->getRowArray();
        if (!$board) {
            $db->table('boards')->insert(['user_id' => $userId, 'name' => 'My Saves', 'category' => 'General']);
            $boardId = $db->insertID();
        } else {
            $boardId = $board['id'];
        }

        // 2. Siapkan data untuk tabel PINS
        $dataToInsert = [
            'board_id'     => $boardId,
            'title'        => $look['title'] ?? 'Untitled',
            'description'  => $look['description'] ?? '', 
            'image_url'    => $look['image_url'] ?? '',
            'user'         => $look['user'] ?? 'anonymous',
            'category'     => $look['category'] ?? 'General',
            'item_details' => is_array($look['item_details']) ? json_encode($look['item_details']) : ($look['item_details'] ?? null),
            'tags'         => is_array($look['tags']) ? json_encode($look['tags']) : ($look['tags'] ?? null)
        ];

        if ($db->table('pins')->insert($dataToInsert)) {
            return $this->respondCreated(['status' => 'success', 'message' => 'Berhasil disimpan!']);
        }
        return $this->fail('Gagal menyimpan ke database.');
    }
}
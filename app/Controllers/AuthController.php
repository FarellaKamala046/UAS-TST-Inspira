<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class AuthController extends Controller {

    // REGISTER: Simpan user baru
    public function register() {
        $db = \Config\Database::connect();
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $data = [
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT) // Password diacak biar aman
        ];

        if ($db->table('users')->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'User terdaftar!']);
        }
    }

    // LOGIN: Cek password & kasih Token
    public function login() {
        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $db->table('users')->where('email', $email)->get()->getRowArray();

        if ($user && password_verify($password, $user['password'])) {
            // Buat Token acak (ini kunci buat akses API nantinya)
            $token = bin2hex(random_bytes(16)); 
            
            // Simpan token ke database agar kita ingat user ini sudah login
            $db->table('users')->where('id', $user['id'])->update(['token' => $token]);

            return $this->response->setJSON([
                'status' => 'success',
                'token'  => $token, // Kasih token ini ke temenmu (Frontend)
                'user'   => $user['username']
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Login Gagal'])->setStatusCode(401);
    }
}
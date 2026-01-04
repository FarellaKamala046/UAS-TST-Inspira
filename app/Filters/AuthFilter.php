<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $db = \Config\Database::connect();
        // Ambil token dari Header 'Authorization'
        $token = $request->getServer('HTTP_AUTHORIZATION');

        if (!$token) {
            return service('response')->setJSON(['message' => 'Token hilang!'])->setStatusCode(401);
        }

        // Cek apakah token ini ada di database user kita
        $user = $db->table('users')->where('token', $token)->get()->getRow();
        if (!$user) {
            return service('response')->setJSON(['message' => 'Token tidak valid!'])->setStatusCode(401);
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\URI;

class CheckSession implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        dump(session()->get()); // Lihat isi session
        dump($request->uri->getPath()); // Lihat URL saat ini
        exit();
        log_message('debug', 'Session Data: ' . json_encode(session()->get('id')));
    
        // Ambil URL saat ini
        $currentPath = $request->uri->getPath();
    
        // Jika belum login dan bukan di halaman login, redirect ke login
        if (!session()->has('id') && $currentPath !== 'absen/login') {
            return redirect()->to('/absen/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }
    

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Biarkan kosong
    }
}
?>
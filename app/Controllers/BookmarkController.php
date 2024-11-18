<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

/** BOOKMARK CONTROLLER
 * Menangani berbagai fungsi terkait bookmark 

    * FUNGSI VIEW BOOKMARKS
    * Mencari dan mengembalikan data bookmark yang dimiliki oleh user
    * Input : user id
    * Output : data pengaduan yang di bookmark oleh user
    * Menuju View Index Pengaduan 

    * FUNGSI ADD BOOKMARK
    * Menambah bookmark
    * Input : user id, pengaduan id
    * Proses : menginput data ke tabel bookmark
    * Output : -

    * FUNGSI REMOVE BOOKMARK
    * Menghilangkan bookmark
    * Input : user id, pengaduan id
    * Proses : menghapus data dari tabel bookmark
    * Output : -
*/
class BookmarkController extends BaseController
{
    public function viewBookmarks($userId) {
        if (!$userId) {
            session()->setFlashdata('failure_message', 'Tolong login terlebih dahulu untuk melihat bookmark');
            return redirect()->to('/login/index');
        }
        // Ambil pengaduan id yang di bookmark oleh user
        $bookmarkedIds = $this->bookmarkModel->getUserBookmarks($userId); 
        // Ambil data pengaduan
        $data['pengaduan'] =[];

        if($bookmarkedIds){
            foreach ($bookmarkedIds as $bookmarkId) {
                $pengaduan = $this->pengaduanModel->find($bookmarkId);
                if ($pengaduan) {
                    $data['pengaduan'][] = $pengaduan;
                }
            }
        }
        $data['bookmarkedIds'] = $bookmarkedIds;
        return view("menu/pengaduan/index_pengaduan", $data);
    }

    public function addBookmark() {
        // Ambil id dari session
        $userId = session()->get('id_user'); 

        if (!$userId) {
            session()->setFlashdata('failure_message', 'Tolong login terlebih dahulu untuk menambah bookmark!');
            return redirect()->to('/login/index');
        }

        // Validasi
        $pengaduanId = $this->request->getPost('pengaduan_id'); //ambil pengaduan id dari request
        
        if (!$pengaduanId) {
            session()->setFlashdata('failure_message', 'Pengaduan invalid!');
            return redirect()->back();
        }

        if ($this->bookmarkModel->findBookmark($userId, $pengaduanId)) {
            session()->setFlashdata('info_message', 'Pengaduan sudah di bookmark!');
            return redirect()->back();
        }

        // Tambahkan bookmark
        $data = [
            'user_id'      => $userId,
            'pengaduan_id' => $pengaduanId,
        ];
        $this->bookmarkModel->insert($data);
        session()->setFlashdata('success_message', 'Pengaduan berhasil di bookmark!');
        return redirect()->back();
    }

    public function removeBookmark() {
        // Ambil id dari session
        $userId = session()->get('id_user'); 

        if (!$userId) {
            session()->setFlashdata('failure_message', 'Tolong login terlebih dahulu untuk menghapus bookmark!');
            return redirect()->to('/login/index');
        }

        // Validasi
        $pengaduanId = $this->request->getPost('pengaduan_id'); // Ambil pengaduan id dari request
        
        if (!$pengaduanId) {
            session()->setFlashdata('failure_message', 'Pengaduan invalid!');
            return redirect()->back();
        }

        // Cari bookmark yang akan dihapus
        $bookmark = $this->bookmarkModel->findBookmark($userId, $pengaduanId);

        if (!$bookmark) {
            session()->setFlashdata('info_message', 'Bookmark tidak ditemukan!');
            return redirect()->back();
        }

        // Hapus bookmark
        if ($this->bookmarkModel->where('user_id', $userId)->where('pengaduan_id', $pengaduanId)->delete()) {
            session()->setFlashdata('success_message', 'Pengaduan tidak lagi di bookmark!');
            return redirect()->back();
        }

        session()->setFlashdata('failure_message', 'Gagal menghilangkan bookmark! Tolong coba lagi.');
        return redirect()->back();
    }
}


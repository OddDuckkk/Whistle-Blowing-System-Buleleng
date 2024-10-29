<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

/** LEVEL CONTROLLER
 * Menangani berbagai fungsi terkait level khusus user 

    * Level default (user/pelapor) secara default dimiliki oleh semua user yang dapat login ke dalam aplikasi
    * Level khusus seperti superadmin, operator, verifikator ditangani pada controller ini

    * FUNGSI GET ALL USER LEVELS
    * Mencari dan mengembalikan semua user yang memiliki level khusus 
    * Menuju View Index Level 

    
*/

class LevelController extends BaseController
{
    public function getAllUserLevels() {
    // Mengambil semua user yang memiliki level khusus
    $usersWithLevels = $this->levelModel->getUsersWithRoles();
        
    // Mengirimkan data kembali ke view IndexUserLevel
    return view('menu/userlevel/index_user_level', ['users' => $usersWithLevels]);
    }

    public function viewAssignUserLevel() {
        // Menampilkan view untuk mengatur level user
        return view('menu/userlevel/assign_user_level');
    }

    public function store() {
        // Get the NIP and level from the form
        $nip = $this->request->getPost('nip');
        $level = $this->request->getPost('level');

        $existingUser = $this->levelModel->where('nip', $nip)->first();

        if ($existingUser) {
            // If NIP already has a level assigned, show an error message
            return redirect()->back()->with('error', 'NIP already has a level assigned. Please update the existing record.')->withInput();
        } else {
            // Assign the new level to the user
            $data = [
                'nip' => $nip,
                'level' => $level,
                'created_at' => date('Y-m-d H:i:s'), // Optionally add created_at
                'updated_at' => date('Y-m-d H:i:s'), // Optionally add updated_at
            ];

            $this->levelModel->save($data);

            // Success message and redirect
            return redirect()->to('/userlevel/assign')->with('success', 'Level successfully assigned to the user.');
        }
    }
}

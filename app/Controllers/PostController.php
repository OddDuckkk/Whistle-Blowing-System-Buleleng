<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PostController extends BaseController
{
    public function viewChat($pengaduanId)
    {
        $data['pengaduan'] = $this->pengaduanModel->find($pengaduanId);
        
        // Retrieve all posts (including replies)
        $posts = $this->postModel->where('pengaduan_id', $pengaduanId)
                                  ->orderBy('created_at', 'ASC')
                                  ->findAll();

        // Process each post
        foreach ($posts as &$post) {
            $post['message'] = $this->decryptMessage($post['message']);
            if($post['parent_id'] ) {
                $parent = $this->postModel->where('id', $post['parent_id'])->first();

                if ($parent) {
                    $post['parent_message'] = $this->decryptMessage($parent['message']);
                }
            }
        }

        $data['posts'] = $posts;

        return view('menu/pengaduan/chat_pengaduan', $data);
    }

    private function getReplies($parentId)
    {
        $postModel = new \App\Models\PostModel();

        // Retrieve replies for the given post (parentId)
        $replies = $postModel->where('parent_id', $parentId)
                             ->orderBy('created_at', 'ASC')
                             ->findAll();

        // Decrypt each reply's message
        foreach ($replies as &$reply) {
            $reply['message'] = $this->decryptMessage($reply['message']);
        }

        return $replies;
    }

    public function store()
    {
        $pengaduanId = $this->request->getPost('pengaduan_id');
        $message = $this->request->getPost('message');
        $parentId = $this->request->getPost('parent_id');
        $userId = session()->get('id_user');

        // Validate the message
        if (empty($message)) {
            return redirect()->back()->with('error', 'Pesan tidak boleh kosong');
        }

        // Encrypt the message
        $encryptedMessage = $this->encrypter->encrypt($message);
        $encryptedMessage = base64_encode($encryptedMessage);

        // Prepare the post data
        $postData = [
            'pengaduan_id' => $pengaduanId,
            'user_id' => $userId,
            'message' => $encryptedMessage,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($parentId) {
            $postData['parent_id'] = $parentId;
        } else {
            $postData['parent_id'] = null;
        }

        // Save the post (either a new post or a reply)
        $this->postModel->save($postData);

        return redirect()->to('/pengaduan/chat/' . $pengaduanId);
    }

    public function delete($postId)
    {
        // Find the post to be "deleted"
        $post = $this->postModel->find($postId);

        if (!$post) {
            return redirect()->back()->with('error', 'Postingan tidak ditemukan.');
        }

        // Update the post message to indicate it has been deleted
        $this->postModel->update($postId, [
            'message' => '',
            'updated_at' => date('Y-m-d H:i:s'),
            'is_deleted' => true,
        ]);

        // Redirect back to the chat
        return redirect()->to('/pengaduan/chat/' . $post['pengaduan_id']);
    }

    private function decryptMessage($encryptedMessage)
    {
        if (empty($encryptedMessage)) {
            return '[Message deleted]';
        }
        try {
            $message = base64_decode($encryptedMessage);
            $message = $this->encrypter->decrypt($message);
            return $message; 
        } catch (\Exception $e) {
            log_message('error', 'Decryption error: ' . $e->getMessage() . ' - Message: ' . $encryptedMessage);
            return '[Error decrypting message]';
        }
    }

    public function getNewMessages($pengaduan_id, $last_timestamp)
{
    // Fetch messages that were created after the last received timestamp
    $messages = $this->postModel
        ->where('pengaduan_id', $pengaduan_id)
        ->where('created_at >', $last_timestamp)
        ->orderBy('created_at', 'ASC')
        ->findAll();

    // Process each post, decrypting the message and handling replies
    foreach ($messages as &$message) {
        $message['message'] = $this->decryptMessage($message['message']);

        if ($message['parent_id']) {
            $parent = $this->postModel->where('id', $message['parent_id'])->first();
            if ($parent) {
                $message['parent_message'] = $this->decryptMessage($parent['message']);
            }
        }
    }

    // Return the messages as a JSON response
    return $this->response->setJSON($messages);
}

    
}

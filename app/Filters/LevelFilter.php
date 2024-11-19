<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LevelFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    
        $userLevels = session('level'); 
        
        if (!$userLevels) {
            return redirect()->to('/login/index')->with('error', 'You must be logged in.');
        }

        if ($arguments) {
            $requiredLevels = is_array($arguments) ? $arguments : [$arguments];
            foreach ($requiredLevels as $requiredLevel) {
                if (in_array($requiredLevel, $userLevels)) {
                    return;
                }
            }
        }

        return redirect()->to('/forbidden');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}

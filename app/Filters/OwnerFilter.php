<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class OwnerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $sessionUserId = session('id_user'); 
        // Get the 3rd and 4th segments
        $requestedUserIdSegment3 = $request->getUri()->getSegment(3); 
        $requestedUserIdSegment4 = $request->getUri()->getSegment(4);

        
        if ($sessionUserId !== $requestedUserIdSegment3 && $sessionUserId !== $requestedUserIdSegment4) {
            return redirect()->to('/forbidden');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
      
    }
}

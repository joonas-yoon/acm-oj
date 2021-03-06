<?php

namespace App\Services\Protects;

use Sentinel;

abstract class BaseServiceProtected
{
    protected $user;
    protected $user_id = null;
    protected $paginateCount = 20;
    
    public function __construct()
    {
    }
    
    public function setUser($user)
    {
        $this->user = $user;
        if($user)
            $this->user_id = $user->id;
    }
    
    public function getUser()
    {
        return $this->user;
    }
}
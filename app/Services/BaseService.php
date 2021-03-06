<?php

namespace App\Services;

use Sentinel;

abstract class BaseService
{
    protected $service;
    
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
        $this->service->setUser($user);
    }
    
    public function getUser()
    {
        return $this->user;
    }
}
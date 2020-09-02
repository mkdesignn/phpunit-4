<?php

namespace App\Models;

class User
{


    public $wallet;

    public function getCurrentUser()
    {
        return $this;
    }

    public function update(array $parameters): self
    {
        $this->wallet = isset($parameters['wallet']) ? $parameters['wallet'] : $this->wallet;
        return $this;
    }
}
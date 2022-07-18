<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    var $user;

    public function __construct($id = null)
    {
        $this->user = $this->getUser($id);
    }

    public function checkDelivery()
    {
        if($this->user) {
            if (!$this->deliveryCheck() || ($this->deliveryAt() || $this->deliveryCount())) {
                return $this->addDelivery();
            }
        }

        return false;
    }

    public function deliveryCheck()
    {
        return $this->user->delivery_count > 0;
    }

    public function deliveryCount()
    {
        return $this->user->delivery_count < env('DAILY_DELIVERY_MAX_COUNT');
    }

    public function deliveryAt()
    {
        return $this->user->delivered_at < now()->startOfDay();
    }

    public function addDelivery()
    {
        if($this->deliveryAt()) $this->user->delivery_count = 0;
        $this->user->delivery_count++;
        $this->user->delivered_at = now();
        $this->user->save();
        return $this->user;
    }

    public function getUser($id)
    {
        return User::find($id);
    }
}

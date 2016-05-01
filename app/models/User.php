<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
    use SoftDeletingTrait;
    protected $dates = ["deleted_at"];

    protected $table  = "user";
    protected $hidden = ["password"];
    
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
      
    public function getAuthPassword()
    {
        return $this->password;
    } 
      
    public function getRememberToken()
    {
        return $this->remember_token;
    }
      
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }
      
    public function getRememberTokenName()
    {
        return "remember_token";
    }
      
    public function getReminderEmail()
    {
        return $this->email;
    }
}
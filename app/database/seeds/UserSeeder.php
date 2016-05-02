<?php
 
class UserSeeder
  extends DatabaseSeeder
{
  public function run()
  {
    $users = [
      /*[
        "username" => "estchuy",
        "name"     => "Estuardo Chuy",
        "password" => Hash::make("chester47707957"),
        "email"    => "estchuy@hotmail.com",
        "user_type_id" => "1", //1 Admin, 2 convencional
        "phone"    => "47707957"
      ]*/
      [
        "username" => "admin",
        "name"     => "Admin",
        "password" => Hash::make("admin"),
        "email"    => "admin@admin.com",
        "user_type_id" => "1", //1 Admin, 2 convencional
        "phone"    => "12345678"
      ]
    ];
  
    foreach ($users as $user) {
      User::create($user);
    }
  }
}
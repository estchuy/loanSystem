<?php

class UsersController extends \BaseController {

	
	public function login()
	{
		if ($this->isPostRequest()) {
      		$validator = $this->getLoginValidator();
  
      		if ($validator->passes()) {
        		$credentials = $this->getLoginCredentials();
  
	        	if (Auth::attempt($credentials)) {
	          		return View::make('layout.content');
	        	}
  
        			return Redirect::back()->withErrors(["password" => ["Credenciales No Validas!!!"]]);
      		} else {
        		return Redirect::back()
          		->withInput()
          		->withErrors($validator);
      		}
      	}else{
      		if(Auth::check()){
      			return View::make('layout.content');
      		}
      	}
		  
  		return View::make("user/login");
	}

	public function home(){
		return View::make('layout.content');
	}

	public function logout()
	{
	  Auth::logout();
	  
	  return Redirect::route("user/login");
	}
	  
	  protected function isPostRequest()
	  {
	    return Input::server("REQUEST_METHOD") == "POST";
	  }
	  
	  protected function getLoginValidator()
	  {
	    return Validator::make(Input::all(), [
	      "username" => "required",
	      "password" => "required"
	    ]);
	  }
	  protected function getLoginCredentials()
	  {
	    return [
	      "username" => Input::get("username"),
	      "password" => Input::get("password")
	    ];
	  }
	}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firurapper\Mercadolibre\Meli;
use Http;

class App extends Controller
{

    public function index(Request $request)
    {
        $this->auth();
		
		return view ('MercadoLibre');
    }
    
    public function auth()
    {
        $app_id = '4978021142448541';
		$secret_key = 'EJ36NKt727IOZ1svrFjwPFBqLYvvG3zh';
		$redirectURI = 'https://meli.softwaresolutionservices.com/MercadoLibre';

		$meli = new Meli($app_id, $secret_key);

		$user = $meli->authorize($_GET['code'], $redirectURI);
        
        session(['access_token' => $user['body']->access_token]);
        session(['expires_in' => $user['body']->expires_in]);
        session(['refresh_token' => $user['body']->refresh_token]);

        return;
    }

    public function show($id){
    	
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firurapper\Mercadolibre\Meli;
use Http;
use Session;

class MercadoLibre extends Controller
{
    public function index()
	{
		$app_id = '4978021142448541';
		$secret_key = 'EJ36NKt727IOZ1svrFjwPFBqLYvvG3zh';

		$meli = new Meli($app_id, $secret_key);

	    $respuesta = Http::get('https://mindicador.cl/api');
	    $dolar = $respuesta->json();

	    $respuesta2 = Http::get('https://jsonplaceholder.typicode.com/posts');
	    $posts = $respuesta2->json();

	    return view('welcome', compact('dolar', 'posts'), ['app_id'=>$app_id]);
	}

	public function autenticarse(Request $request){
		$app_id = '4978021142448541';
		$secret_key = 'EJ36NKt727IOZ1svrFjwPFBqLYvvG3zh';
		$redirectURI = 'https://meli.softwaresolutionservices.com/MercadoLibre';

		$meli = new Meli($app_id, $secret_key);

		$auth = $meli->getAuthUrl($redirectURI, Meli::$AUTH_URL['MLA']);
		
		if($request->session()->get('access_token'))
		{
		    $access_token = $request->session()->get('access_token');
		    //Grupo Tecno ID: 116239336
		    $items = Http::get('https://api.mercadolibre.com/v1/claims/search?status=opened&sort=last_updated:desc&access_token='.$access_token);
		    $item = $items->json();
		    
		    //dd($item);
		    
		    $data = $item['data'];
		    
		    return view('autenticado', ['autenticar'=>$auth, 'reclamos'=>$data]);
		} else {
		    return view('autenticado', ['autenticar'=>$auth]);
		}
	}
}

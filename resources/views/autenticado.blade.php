<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    @if(session('access_token'))
        <div class="container">
    	    <div class="row">
    	        <?php if($reclamos){ ?>
        	        @foreach($reclamos as $item)
        	        
        	        <?php
        	        
        	        if(session('access_token')){
        	            $order = Http::get('https://api.mercadolibre.com/orders/'.$item['resource_id'].'?access_token='.session('access_token'));
        	            $order = $order->json();
        	            
        	            $seller = Http::get('https://api.mercadolibre.com/users/'.$item['players']['1']['user_id'].'?access_token='.session('access_token'));
        	            $seller = $seller->json();
        	            
        	            $det_item = Http::get('https://api.mercadolibre.com/items/'.$order['order_items']['0']['item']['id']);
        	            $det_item = $det_item->json();
        	            
        	           //Comentario
        	            
        	            $buyer = $order['buyer']['first_name'].' '.$order['buyer']['last_name'];
        	            
                        $mensajes = Http::get('https://api.mercadolibre.com/v1/claims/'.$item['id'].'/messages?access_token='.session('access_token'));
                        $mensajes = $mensajes->json();
                        
                        
                    }
        	        ?>
        	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        	                <div class="card mb-3">
                              <div class="row no-gutters">
                                <div class="col-md-4">
                                  <img src="{{$det_item['thumbnail']}}" class="card-img" alt="{{$det_item['title']}}">
                                </div>
                                <div class="col-md-8">
                                  <div class="card-body">
                                    <h5 class="card-title">
                                        {{$buyer}}
                                        <small class="text-muted"><?php if($item['type']=="returns")
                                        { ?>
                                        Devolución
                                        <?php } elseif($item['type']=="mediations")
                                        { ?> 
                                        Reclamo 
                                        <?php } ?>
                                         #{{ $item['id'] }}
                                         </small>
                                    </h5>
                                    <h6>{{$det_item['title']}}</h6>
                                    <p class="card-text">
                                        <?php if($item['stage']=="claim")
                                         { ?>
                                         Reclamo sin Mediacion
                                         <?php } elseif($item['stage']=="dispute")
                                         { ?>
                                         Reclamo con Mediacion
                                         <?php } ?>
                                    </p>
                                    <p class="card-text"><small class="text-muted">Fecha de Creacion: {{$item['date_created']}}</small></p>
                                    <p class="card-text">
                                        <?php
                                        //if($item['type']=="returns"){ } else {
                                            for($i=count($mensajes)-1; $i>=0; $i--){
                                             echo $mensajes[$i]['message'].'<br><br>';   
                                            }
    	                                //}
                                        ?>
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    @endforeach
                <?php } else { ?>
                    <h1>No hay reclamos activos para mostrar</h1>
                <?php } ?>
    	    </div>
    	</div>
    @else
        <p>
          <a href="{{$autenticar}}" class="btn btn-success">Loguearse con ML</a>
        </p>
    @endif
</body>
</html>
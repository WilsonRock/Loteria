<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Traits\ConsumeExternalServices;
use App\Traits\InteractsWithTransactionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class RequestService {
  use ConsumeExternalServices;

  protected $providerRepository;
  protected $baseUri;
  protected $userKey;

  public function __construct(

  )
  {
      //$this->providerRepository = $providerRepository;
      $this->baseUri = config("services.transaction.base_uri");
      $this->userKey = config("services.transaction.user_key");
  }

  public function index() {
      return $this->providerRepository->all(null);
  }

  public function store($data) {
      return $this->providerRepository->create($data);
  }

/*   public function update(array $data, Provider $provider)
  {
      return $this->providerRepository->update($data, $provider->id);
  }
 */
public function getPrueba($data)
{
    try {
        $response = Http::withHeaders([
            "Accept" => "*/*",
            'AppKey' => 'betappkey-test1-T3L38K',
            'AppToken' => 'CUKXOF6ZJVIMKJJGTKJ2YSZJ4P040DQ15GDJBN74CFOF906RCOOXTECSRCGRRADOOLCYFJUDU123ESRXADTRICFTWBW3H78DQFS47OHU7IQ7VCWXYD6E1R7FQL0JX24GNSWJ6K99HTZ3BJXS8AYFS0I29M84XM1OSJ1HO9O57ARK9TN62V2JTUC49VSH4EY9XV202KNMOGXWQC4U9VH7S3RQMOR87R3VXXUHHR4ZOI7WQEJ49AO4SS3VLAE3ZN33',
            'Content-Type' => 'application/json'
        ])->get("https://app-betprovider.onrender.com/api/v1/games/{$data['codigoprovider']}");
        
        if ($response->ok()) {
            $responseData = json_decode($response->body(), true);
            return $responseData;
        } else {
            $errorMessage = $response->json()['message'];
            return response()->json(['error' => $errorMessage], $response->status());
        }
    } catch (\Exception $e) {
        // Handle the exception
        return response()->json(['error' => '¡Ups, algo va mal! Puede volver a intentarlo o contactar con el administrador'], 500);
    }
}


  public function SalesQuery(Request $data)

  {
    $req = $data->vendidos;
   // dd($data->cliente_id);
    //echo($data);
    $data = [
          'betNumber' => $data['bet_number'],
          'amount' => $data['valor'],
          'commerce'=> 2,
          'raffle'=> 1,
          'stateSale'=> 1
      ];
     // $response = $this->makeRequest('POST', $this->baseUri . "superpagos/products/query", [], $data);
    //$response = $this->makeRequest("POST", "http://localhost:3000" . "/sales", [], $data ,  Http::withHeaders(['headers' => ['ApiKey' => 'betappkey-2-B0A1C1','ApiToken' => '59SGQ81SHPUB1XLJC1FOR0OSYCE1G7ICZTM1XI'] ]) );
    $response = Http::withHeaders([
        'Accept'=> '*/*',  
        'AppKey' => 'betappkey-test1-T3L38K',
        'AppToken' => 'CUKXOF6ZJVIMKJJGTKJ2YSZJ4P040DQ15GDJBN74CFOF906RCOOXTECSRCGRRADOOLCYFJUDU123ESRXADTRICFTWBW3H78DQFS47OHU7IQ7VCWXYD6E1R7FQL0JX24GNSWJ6K99HTZ3BJXS8AYFS0I29M84XM1OSJ1HO9O57ARK9TN62V2JTUC49VSH4EY9XV202KNMOGXWQC4U9VH7S3RQMOR87R3VXXUHHR4ZOI7WQEJ49AO4SS3VLAE3ZN33',
        'Content-Type'=> 'application/json',
        
    ])->post('https://app-betprovider.onrender.com/api/v1/sales', 
        $data
    );
 
    //echo($response);
    $response = $response->getBody()->getContents();
    
    return $response;
  }

  public function findProductsByProvider($provider)
  {
      return $this->providerRepository->findProductsByProvider($provider);
  }
  
  public function generateWinner($data){
    { 
       try {
        //code...
       // echo($data['numero']);
        
        $req = $data->vendidos;
        $data = [
            "numero"=>$data->numero,
            "sorteo"=> $data->sorteo
          ];
       //   echo($data);
            $response = Http::withHeaders([
            'AppKey' => 'betappkey-test1-T3L38K',
            'AppToken' => 'CUKXOF6ZJVIMKJJGTKJ2YSZJ4P040DQ15GDJBN74CFOF906RCOOXTECSRCGRRADOOLCYFJUDU123ESRXADTRICFTWBW3H78DQFS47OHU7IQ7VCWXYD6E1R7FQL0JX24GNSWJ6K99HTZ3BJXS8AYFS0I29M84XM1OSJ1HO9O57ARK9TN62V2JTUC49VSH4EY9XV202KNMOGXWQC4U9VH7S3RQMOR87R3VXXUHHR4ZOI7WQEJ49AO4SS3VLAE3ZN33',
            
        ])->post('https://app-betprovider.onrender.com/api/v1/sales/generate/winners', 
            $data
        );
      $response = $response->getBody()->getContents();
        return $response;
       } catch (\Throwable $th) {
        return response()->json(['error' => 'No cuenta con saldo suficiente para realizar la venta','data' => $response], 400);
       }
     
      }

  } 

  public function rules($data){
    { 
     
      try {
   
          $data = [
            "numero"=>$data->id
          ];
            $response = Http::withHeaders([
            'AppKey' => 'betappkey-test1-T3L38K',
            'AppToken' => 'CUKXOF6ZJVIMKJJGTKJ2YSZJ4P040DQ15GDJBN74CFOF906RCOOXTECSRCGRRADOOLCYFJUDU123ESRXADTRICFTWBW3H78DQFS47OHU7IQ7VCWXYD6E1R7FQL0JX24GNSWJ6K99HTZ3BJXS8AYFS0I29M84XM1OSJ1HO9O57ARK9TN62V2JTUC49VSH4EY9XV202KNMOGXWQC4U9VH7S3RQMOR87R3VXXUHHR4ZOI7WQEJ49AO4SS3VLAE3ZN33',
            
        ])->get('https://app-betprovider.onrender.com/api/v1/rules/'.$data['numero'], 
        );
      echo($response);
     return response()->json(['data' => $response], 201);
       } catch (\Throwable $th) {
        return response()->json(['error' => 'Error','data' => $response], 400);
       }     
      }
  }
  public function getWinners($data){
    { 
       try {
       // echo($data->numero);
        $datas = [
          "numero"=>$data->numero,
          "sorteo"=>$data->sorteo
          ];
         // echo($data);


         $response = Http::withHeaders([
          'AppKey' => 'betappkey-test1-T3L38K',
          'AppToken' => 'CUKXOF6ZJVIMKJJGTKJ2YSZJ4P040DQ15GDJBN74CFOF906RCOOXTECSRCGRRADOOLCYFJUDU123ESRXADTRICFTWBW3H78DQFS47OHU7IQ7VCWXYD6E1R7FQL0JX24GNSWJ6K99HTZ3BJXS8AYFS0I29M84XM1OSJ1HO9O57ARK9TN62V2JTUC49VSH4EY9XV202KNMOGXWQC4U9VH7S3RQMOR87R3VXXUHHR4ZOI7WQEJ49AO4SS3VLAE3ZN33',
          
      ])->post('https://app-betprovider.onrender.com/api/v1/sales/generate/winners', 
          $datas
      );
     $response = $response->getBody()->getContents();
     return $response;
       } catch (\Throwable $th) {
        return response()->json(['error' => 'No cuenta con saldo suficiente para realizar la venta','data' => $response], 400);
       }
     
      }

  }
  
  public function Qr($data){
    { 
       try {
        //code...
       //echo($data);
       if(isset($data->id)){
        $data = [
          "numero"=>$data->id
        ];
       }else{
     //   dd("tara");
        $data = [
          "numero"=>$data
        ];
       }
       //   echo($data);
            $response = Http::withHeaders([
            'AppKey' => 'betappkey-test1-T3L38K',
            'AppToken' => 'CUKXOF6ZJVIMKJJGTKJ2YSZJ4P040DQ15GDJBN74CFOF906RCOOXTECSRCGRRADOOLCYFJUDU123ESRXADTRICFTWBW3H78DQFS47OHU7IQ7VCWXYD6E1R7FQL0JX24GNSWJ6K99HTZ3BJXS8AYFS0I29M84XM1OSJ1HO9O57ARK9TN62V2JTUC49VSH4EY9XV202KNMOGXWQC4U9VH7S3RQMOR87R3VXXUHHR4ZOI7WQEJ49AO4SS3VLAE3ZN33',
            
        ])->get('https://app-betprovider.onrender.com/api/v1/sales/'.$data['numero'], 
           );
                $response = $response->getBody()->getContents();
         return json_decode($response,true);

       } catch (\Throwable $th) {
        return response()->json(['error' => 'No cuenta con saldo suficiente para realizar la venta','data' => $response], 400);
       }
     
      }

  } 

  public function Payment($data){
    { 
       try {
        $dataID=5;
        $body = [ 
          "stateSale"=>$dataID,
        ];
        $data = [  
          "numero"=>$data->number
        ];
       //   echo($data);
            $response = Http::withHeaders([
            'AppKey' => 'betappkey-test1-T3L38K',
            'AppToken' => 'CUKXOF6ZJVIMKJJGTKJ2YSZJ4P040DQ15GDJBN74CFOF906RCOOXTECSRCGRRADOOLCYFJUDU123ESRXADTRICFTWBW3H78DQFS47OHU7IQ7VCWXYD6E1R7FQL0JX24GNSWJ6K99HTZ3BJXS8AYFS0I29M84XM1OSJ1HO9O57ARK9TN62V2JTUC49VSH4EY9XV202KNMOGXWQC4U9VH7S3RQMOR87R3VXXUHHR4ZOI7WQEJ49AO4SS3VLAE3ZN33',
         
        ])->patch('https://app-betprovider.onrender.com/api/v1/sales/'.$data['numero'], 
        $body,     
      );
      $response = $response->getBody()->getContents();
     return $response;
        
       } catch (\Throwable $th) {
        return response()->json(['error' => 'No cuenta con saldo suficiente para realizar la venta','data' => $response], 400);
       }
     
      }

  }
  
  public function RafflesQuery($data){
    { 
       try {
        $data = [  
          "numero"=>$data->raffle
        ];
       

            $response = Http::withHeaders([
            'AppKey' => 'betappkey-test1-T3L38K',
            'AppToken' => 'CUKXOF6ZJVIMKJJGTKJ2YSZJ4P040DQ15GDJBN74CFOF906RCOOXTECSRCGRRADOOLCYFJUDU123ESRXADTRICFTWBW3H78DQFS47OHU7IQ7VCWXYD6E1R7FQL0JX24GNSWJ6K99HTZ3BJXS8AYFS0I29M84XM1OSJ1HO9O57ARK9TN62V2JTUC49VSH4EY9XV202KNMOGXWQC4U9VH7S3RQMOR87R3VXXUHHR4ZOI7WQEJ49AO4SS3VLAE3ZN33',
         
        ])->get('https://app-betprovider.onrender.com/api/v1/raffles/'.$data['numero'], 
       
      );
      $response = $response->getBody()->getContents();
       $a  = json_decode($response,true);
   //   dd($a);
      return $a;
      //dd($response = $response->getBody()->getContents());
     // return $response;
        
       } catch (\Throwable $th) {
        return response()->json(['error' => 'No cuenta con saldo suficiente para realizar la venta','data' => $response], 400);
       }
     
      }

  } 

  



}


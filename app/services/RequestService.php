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
        $param = [
            'codigoprovider' => $data['codigoprovider'],
           ];
        $response = Http::withHeaders([
            "Accept"=> "*/*",
            'AppKey' => 'betappkey-2-DBB100',
            'AppToken' => 'JC05HQPDAEQLMJS003FQX6AZGIQDQT7N2BOHX',
            'Content-Type' => 'application/json'
      
        ])->get('http://bet-api-provider.herokuapp.com/games'.$data['codigoprovider'],
    
        );

       $all_data = array();
       //$all_data = $response;
       $respt =[
        'codigoprovider' => $response['id'],
       ];

       $a = json_encode($response);
       array_Push($all_data,$a);

       echo($response);

      $a = json_encode($respt);
      
    } catch (\Exception $e) {
        //Log::error($e);  //  json(['message' => 'Juego creado con éxito','data' => $response], 201
        return response()->json(['error' => 'No cuenta con saldo suficiente para realizar la venta','data' => $response], 400);

        //return ("Consulta erronea");
       // return $this->errorResponse(null, '¡Ups, algo va mal! Puede volver a intentarlo  o contactar con el administrador', 500);
    }
  }

  public function SalesQuery(Request $data)

  {
    $req = $data->vendidos;
   // dd($data->cliente_id);
    //echo($data);
    $data = [
          'bet_number' => $data['bet_number'],
          'amount' => $data['valor'],
          'commerce'=> 2,
          'raffle'=> 1,
          'stateSale'=> 1
      ];
     // $response = $this->makeRequest('POST', $this->baseUri . "superpagos/products/query", [], $data);
    //$response = $this->makeRequest("POST", "http://localhost:3000" . "/sales", [], $data ,  Http::withHeaders(['headers' => ['ApiKey' => 'betappkey-2-B0A1C1','ApiToken' => '59SGQ81SHPUB1XLJC1FOR0OSYCE1G7ICZTM1XI'] ]) );
    $response = Http::withHeaders([
        'AppKey' => 'betappkey-2-DBB100',
        'AppToken' => 'JC05HQPDAEQLMJS003FQX6AZGIQDQT7N2BOHX',
        
    ])->post('https://bet-api-provider.herokuapp.com/sales', 
        $data
    );
    //echo($response);
 return response()->json(['message' => 'Juego creado con éxito','data' => $response], 201);
  }

  public function findProductsByProvider($provider)
  {
      return $this->providerRepository->findProductsByProvider($provider);
  }
}
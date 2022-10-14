<?php

namespace App\Http\Controllers;

use App\Models\Entities;
use App\Models\NodeHasNodes;
use App\Models\Nodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Raffles;


use App\services\BalanceService;
class TurnoverController extends Controller
{



    protected $BalanceService;

    public function __construct(
        BalanceService $BalanceService
        
    )
    {
        $this->BalanceService = $BalanceService;
    }


    public function destroy(Entities $entities)
    {
        //
    }


    public function conciliation(Request $request, Entities $commerce)
    {
       // 

       
       return $this->BalanceService->getTotalsConciliationReport($request, $commerce);
       // dd("echo");
    }
}

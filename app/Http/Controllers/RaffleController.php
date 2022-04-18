<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use App\Models\Sale;
use App\Models\Payment;
use App\Models\Client;
use Illuminate\Http\Request;
use DB;

class RaffleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $raffles = Raffle::orderByDesc('created_at')->get();
        return response()->json([$raffles]);
    }

    public function rafflesStates()
    {
        $raffles = Raffle::where('state','1')->orderByDesc('created_at')->get();
        return response()->json([$raffles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $raffle = Raffle::create($request->all());
        return response()->json(["Rifa creada con exito"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Raffle  $raffle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $raffle = Raffle::where('id',$id)->first();
        return response()->json([$raffle]);
    }

    public function saveRaffle(Request $request)
    {

        $sale = Sale::create([
            "boleta_one" => $request->boleta_one,
            "boleta_two" => $request->boleta_two,
            "client_id"  => $request->client_id,
            "code"       => $request->code,
            "raffle_id"  => $request->raffle_id

        ]);

        $abono = Payment::create([
            "sale_id" => $sale->id,
            "pay"     => $request->abono
        ]);
        return response()->json(["estamos ok"]);
    }

    public function updateState($id, $state)
    {
        $state = Raffle::where('id',$id)->update(["state"=>$state]);
        return response()->json(["actualizado con exito"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Raffle  $raffle
     * @return \Illuminate\Http\Response
     */
    public function edit(Raffle $raffle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Raffle  $raffle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Raffle $raffle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Raffle  $raffle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Raffle $raffle)
    {
        //
    }

    public function consultarVenta($id, $option, $datos)
    {
        if($option == 1){
            $data = Sale::withCount(['payments'=> function($query){
                $query->select(DB::raw("SUM(payments.pay) as total_abono"));
            }])->with(['raffle','client'=> function($query) use ($datos){
                $query->where('clients.name','like', '%'.$datos.'%');
            }])
            ->where('raffle_id',$id)
            ->get();
        }
        if($option == 2){
            $data = Sale::withCount(['payments'=> function($query){
                $query->select(DB::raw("SUM(payments.pay) as total_abono"));
            }])->with('client','raffle')
            ->where([
                ['raffle_id',$id],
                ['boleta_one',$datos]
            ])
            ->get();
        }
        if($option == 3){
            $data = Sale::withCount(['payments'=> function($query){
                $query->select(DB::raw("SUM(payments.pay) as total_abono"));
            }])->with('client','raffle')
            ->where([
                ['raffle_id',$id],
                ['boleta_two',$datos]
            ])
            ->get();
        }
       
        return response()->json([$data]);
    }

    public function savePay($id, $pay)
    {
        $pay = Payment::create([
            "sale_id"   =>$id,
            "pay"       => $pay
        ]);

        return response()->json(["abono con exito.!"]);
    }

    public function saleTotal($id)
    {
        $data = Sale::withCount(['payments'=> function($query){
            $query->select(DB::raw("SUM(payments.pay) as total_abono"));
        }])->with('client','raffle')
        ->where('raffle_id',$id)
        ->get();

        return response()->json([$data]);   
    }
}

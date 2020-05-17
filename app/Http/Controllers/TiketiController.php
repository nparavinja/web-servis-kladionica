<?php

namespace App\Http\Controllers;

use App\Pair;
use App\Ticket;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TiketiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    //POST localhost/test-laravel/public/tiketi
    public function store(Request $request)
    {
        //
        try {
            $tiket = new Ticket;
            $tiket->datumIVremeOdigravanja = $request->datumIVremeOdigravanja;

            $tiket->uplacenIznos = $request->uplacenIznos;
            $tiket->ukupnaKvota = $request->ukupnaKvota;
            $tiket->ukupanDobitak = $request->ukupanDobitak;
            $tiket->status = $request->status;
            $tiket->aktivan = $request->aktivan;
            $tiket->user_id = $request->korisnikID;
            $parovi = $request->parovi;
            $tiket->save();
            $id = $tiket->id;
            foreach($parovi as $par) {
                $p = new Pair;
                $p->tiket_id = $id;
                $p->kvota_id = $par['kvotaID'];
                $p->game_id = $par['utakmicaID'];
                $p->save();

            }

          return response($tiket,200);

        }catch(Exception $e) {
            $response['error'] = $e->getMessage();
            $response['success'] = false;
            return response($response,404);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // GET localhost/test-laravel/public/tiketi/{$id}
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // DELETE localhost/test-laravel/public/tiketi/{id}
    public function destroy($id)
    {
        //
        try {
            $tiket = Ticket::findOrFail($id);
            $tiket->delete();
            $response['status'] = true;
            $response['message'] = "Uspesno obrisan izabrani tiket.";

            return response($response,200);

        } catch(ModelNotFoundException $ex) {
            $response['status'] = false;
            $response['message'] = "Tiket sa izabranim id ne postoji u bazi.";
            return response($response, 404);

        } catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            return response($response, 404);
        }
    }
}

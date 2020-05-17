<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Player;
use App\Team;
use App\Game;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UtakmiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // GET localhost/test-laravel/public/utakmice
    public function index()
    {
        $games = Game::all();

        foreach ($games as $game) {
            // dovlacimo iz baze
            $timDomacin = Game::find($game['id'])->team;
            $igraciD = Team::find($timDomacin['id'])->players;
            $timDomacin['players'] = $igraciD;
            $timGost = Game::find($game['id'])->team_guest;
            $igraciG = Team::find($timGost['id'])->players;
            $timGost['players'] = $igraciG;
            // format odgovora
            $game['timDomacin'] = $timDomacin;
            $game['timGost'] = $timGost;
            $game['kvote'] = Game::find($game['id'])->kvote;
            unset($game['team_id']);
            unset($game['team_guest_id']);
        }

        //$games = $games->toJson(JSON_PRETTY_PRINT);
        return response($games, 200);


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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // GET localhost/test-laravel/public/utakmice/1
    public function show($id)
    {
        //
        try {
            $game = Game::findOrFail($id);
            $timDomacin = Game::find($id)->team;
            $timDomacin['players'] = Team::find($timDomacin['id'])->players;
            $timGost = Game::find($id)->team_guest;
            $timGost['players'] = Team::find($timGost['id'])->players;
            $game['kvote'] = Game::find($id)->kvote;
            // format odgovora
            $game['timDomacin'] = $timDomacin;
            $game['timGost'] = $timGost;
            unset($game['team_id']);
            unset($game['team_guest_id']);
            return response($game, 200);
        }
        // catch(Exception $e) catch any exception
        catch (ModelNotFoundException $e) {
            abort(404, 'Oops...Not found!');
          //  $odgovor['status'] = '404 Not Found';
           // response($odgovor, 404);
        }






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
    public function destroy($id)
    {
        //
    }
}

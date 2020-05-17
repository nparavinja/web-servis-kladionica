<?php

namespace App\Http\Controllers;

use App\Korisnik;
use App\Ticket;
use App\Pair;
use Illuminate\Http\Request;
use App\Game;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class KorisniciController extends Controller
{
    //https://stackoverflow.com/questions/55327542/laravel-5-8-7-page-expired-419
    //https://laravel.com/docs/5.8/csrf#csrf-excluding-uris
    //https://stackoverflow.com/questions/52389565/laravel-419-error-on-post-request-via-postman

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //
    public function index()
    {
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

    //POST api/utakmice
    //POST ../utakmice/ --> vraca get request u postmanu VRLO GLUPO!
    //POST localhost/test-laravel/public/korisnici
    public function register(Request $request)
    {

        try {
            $username = $request['username'];
            $korisnik_test = DB::select('SELECT * FROM users WHERE username = ?', [$username]);


            if (isset($korisnik_test[0]->id)) {
                $response['success'] = false;
                $response['error'] = "Username " . $korisnik_test[0]->username . " vec postoji u bazi.";
                return response($response, 404);
            } else {

                $korisnik = new User;
                //$korisnik->ime = $request->ime;
                $korisnik->ime = $request['ime'];
                $korisnik->mejl = $request['mejl'];
                $korisnik->username = $username;
                $korisnik->password = $request['password'];
                $korisnik->iznosNaRacunu = 500;
                $korisnik->save();
                $response['success'] = true;
                $response['message'] = "Uspesno kreiran novi korisnik";
                return response($response, 200);

            }

        } catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = $e->getMessage();
            return response($response, 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $username = $request->username;
            $password = $request->password;
            $korisnik = DB::select('SELECT * FROM users WHERE username = ? AND password = ?', [$username, $password]);

            if (isset($korisnik[0]->id)) {
                $response = $this->vratiKorisnika($korisnik[0]->id);
                return response($response, 200);
            } else {
                $response['data'] = "Neuspesan login.";
                $response['success'] = false;
                return response($response, 404);
            }
        } catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = $e->getMessage();
            return response($response, 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // GET localhost/test-laravel/public/korisnici/1
    public function show($id)
    {

        try {
            $korisnik = $this->vratiKorisnika($id);
            return response($korisnik, 200);
        } catch (ModelNotFoundException $e) {
            $response['data'] = "Greska u vracanju korisnika.";
            $response['success'] = false;
            return response($response, 404);
        } finally {
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
    // PUT localhost/test-laravel/public/korisnici/1
    public function update(Request $request, $id)
    {

        $username = $request->username;
        $password = $request->password;
        $korisnik = DB::select('SELECT * FROM users WHERE username = ? AND password = ?', [$username, $password]);

        if (isset($korisnik[0]->id)) {
            $response['korisnik'] = $this->vratiKorisnika($korisnik[0]->id);
            return response($response, 200);
        } else {
            $response['data'] = "Neuspesan login.";
            $response['success'] = false;
            return response($response, 404);
        }
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

    private function vratiKorisnika($id)
    {
        $user = Korisnik::findOrFail($id);
        unset($user['password']);

        $tiketi = Korisnik::find($id)->tiketi;
        foreach ($tiketi as $tiket) {

            $parovi = Ticket::find($tiket['id'])->parovi;

            foreach ($parovi as $par) {
                $utakmica = Pair::find($par['id'])->utakmica;
                unset($utakmica['statistic_id']);
                unset($utakmica['team_id']);
                unset($utakmica['team_guest_id']);
                $kvota = Pair::find($par['id'])->kvota;
                $utakmica['timDomacin'] = Game::find($utakmica['id'])->team;
                $utakmica['timGost'] = Game::find($utakmica['id'])->team_guest;
                $par['utakmica'] = $utakmica;
                $par['kvota'] = $kvota;
                unset($par['tiket_id']);
                unset($par['kvota_id']);
                unset($par['game_id']);
            }
            $tiket['parovi'] = $parovi;
        }

        $user['tiketi'] = $tiketi;
        return $user;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\myException;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;


class ContactController extends Controller
{
    //

    public function sendContactForm(Request $request) {
        try {
            $validation = $request->validate([
                'email' =>  'required|email',
                'nom_complet'   =>  'required|string',
                'objet'    =>  'required|string',
                'message'   =>  'required|string'
            ],[
                'email' =>  'Saisissez une adresse email correcte !',
                'required'  =>  '`:attribute`  obligatoire !'
            ]);

            Mail::to('bangourayans47@gmail.com')
                ->send(new Contact([
                    'email' =>  $request->input('email'),
                    'nom_complet'   =>  $request->input('nom_complet'),
                    'objet'   =>   $request->input('objet'),
                    'message'   =>  $request->input('message')
            ]));

            return response()
                ->json('done');
        } catch(myException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }
}

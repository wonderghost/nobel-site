<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\myException;
use App\Sections;
use Illuminate\Support\Str;
use App\SousSections;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function makeEditRequest(Request $request) {
        try {
            $data = SousSections::find($request->input('slug'));
            $data->title = $request->input('title');
            $data->description = $request->input('description');

            if($request->hasFile('illustration')) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $data->illustration = Str::slug($request->input('title')).'.'.$extension;
                                
                if($request->file('image')->move(config('illustration.path'),$data->illustration)) {
                    $data->save();
                } else {
                    throw new AppException("Erreur de telechargement de l'image!");
                }
            }
            $data->save();

            return response()
                ->json('done');
        } catch(myException $e) {
            header("Erreur",true,422);
            die(jsone_encode($e->getMessage()));
        }
    }

    public function getSection(Sections $s) {
        try {
            $sections = $s->all();
            $all = [];
            foreach($sections as $key => $value) {
                // $ssections = $value->
                $all[$key] = [
                    'section'   =>  $value,
                    'sous_section'  =>  $value->sousSections()
                ];
            }

            return response()
                ->json([
                    'section'   => $sections,
                    'sous_section'  =>  $all
                ]);
        } catch(myException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function addSousSection(Request $request) {
        try {
            $validation = $request->validate([
                'title' =>  'required|string',
                'section'   =>  'required|exists:sections,slug'
            ],[
                'required'  => '`:attribute` est requis',
                'exists'    =>  '`:attribute` n\'existe pas !'
            ]);

            $ssection = new SousSections;
            $ssection->slug = Str::slug($request->input('title'));
            $ssection->title = $request->input('title');
            $ssection->description = $request->input('content');
            $ssection->id_section = $request->input('section');

            // verifier si l'image existe
            if($request->hasFile('image')) {

                $extension = $request->file('image')->getClientOriginalExtension();
                $ssection->illustration = Str::slug($request->input('title')).'.'.$extension;
                                
                if($request->file('image')->move(config('illustration.path'),$ssection->illustration)) {
                    $ssection->save();
                } else {
                    throw new AppException("Erreur de telechargement de l'image!");
                }
            }
            else {
                $ssection->save();
            }
            
            return response()
                ->json('done');

        } catch(myException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\myException;
use App\Sections;

class PagesController extends Controller
{
    //

    public function index() {
        // home page
        return view('acceuil');
    }

    public function ourServices($slug) {
        return view('services')
            ->withSlug($slug);
    }

    public function getInfosService(Request $request) {
        try {
            $service = Sections::find($request->input('slug'));
            $ssection = $service->sousSections();

            return response()
                ->json([
                    'service'   =>  $service,
                    'sous_service'  =>  $ssection
                ]);
        } catch(myException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function getSection(Sections $s) {
        try {
            $sections = $s->select()->orderBy('position','asc')->get();
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
}

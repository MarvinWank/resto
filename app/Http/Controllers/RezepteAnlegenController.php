<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class RezepteAnlegenController extends Controller
{
    public function anlegen(Request $request)
    {
        $data = $request->json();
    }
}

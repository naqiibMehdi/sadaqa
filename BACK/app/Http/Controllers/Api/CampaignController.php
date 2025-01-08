<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CampaignController extends Controller
{
    public function index()
    {
        return response()->json(["campaigns" => Campaign::all()], 200);
    }


    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'error' => 'Mauvais format de l\'ID',
                'message' => 'L\'ID de la campagne doit être un entier.'
            ], 400); // Retourne une erreur 400 (Bad Request) si l'ID n'est pas un entier
        }
    }
}

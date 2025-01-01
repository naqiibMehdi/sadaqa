<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        User::create([
            "name" => "benamar",
            "first_name" => "mehdi",
            "public_name" => "test",
            "birth_date" => "2025-01-01",
            "email" => "test@gmail.com",
            "password" => "1234",
            "subscribe_date" => "2025-01-01",
            "img_profile" => "test.jpg",
            "id_address" => 1,
        ]);

        return response()->json(["message" => "enregistré"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

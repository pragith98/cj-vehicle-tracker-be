<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     summary="Get users",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index()
    {
        // Display a listing of the resource.
    }

    public function create()
    {
        // Show the form for creating a new resource.
    }

    public function store(Request $request)
    {
        // Store a newly created resource in storage.
    }

    public function show($id)
    {
        // Display the specified resource.
    }

    public function edit($id)
    {
        // Show the form for editing the specified resource.
    }

    public function update(Request $request, $id)
    {
        // Update the specified resource in storage.
    }

    public function destroy($id)
    {
        // Remove the specified resource from storage.
    }
}
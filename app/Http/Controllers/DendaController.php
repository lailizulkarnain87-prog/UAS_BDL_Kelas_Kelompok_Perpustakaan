<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Http\Requests\StoreDendaRequest;
use App\Http\Requests\UpdateDendaRequest;

class DendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDendaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Denda $denda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDendaRequest $request, Denda $denda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Denda $denda)
    {
        //
    }
}

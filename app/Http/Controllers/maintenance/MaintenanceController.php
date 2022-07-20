<?php

namespace App\Http\Controllers\maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        dd('bien');
        return view('dvhive.maintenance.maintenance');
    }
    public function findStudent(){

        dd('buscar alumno');
    }
    public function editStudent(){

        dd('guardar cambios');
    }
}

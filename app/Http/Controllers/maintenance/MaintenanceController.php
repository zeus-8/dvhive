<?php

namespace App\Http\Controllers\maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use JeroenNoten\LaravelAdminLte\View\Components\Form\Select;
use stdClass;

class MaintenanceController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        $modal = 0;
        $resu = 0;
        //dd($modal, $resu);
        return view('dvhive.maintenance.maintenance', compact('modal', 'resu'));
    }
    public function findStudent(Request $request){
        if ($request['career']) {
            $resu = DB::connection('think_ed')
                        ->table('persons')
                        ->join('persons_careers', 'persons_careers.id_person', '=', 'persons.id')
                        ->join('careers', 'persons_careers.id_career', '=', 'careers.id')
                        ->Select('persons.id', 'persons.pin', 'persons.name', 'persons.surname', 'persons.email', 'persons.tel', 'persons_careers.id_person', 'persons_careers.id_career', DB::raw('careers.name as career'), 'persons_careers.id_turn', 'persons_careers.period_year', 'persons_careers.period_init', 'persons_careers.is_online')
                        ->where('persons.pin', 'like', '%'.$request['document'].'%')
                        ->where('persons_careers.id_career', '=', $request['career'])
                        ->get();
        } else {
            $resu = DB::connection('think_ed')
                        ->table('persons')
                        ->join('persons_careers', 'persons_careers.id_person', '=', 'persons.id')
                        ->join('careers', 'persons_careers.id_career', '=', 'careers.id')
                        ->Select('persons.id', 'persons.pin', 'persons.name', 'persons.surname', 'persons.email', 'persons.tel', 'persons_careers.id_person', 'persons_careers.id_career', DB::raw('careers.name as career'), 'persons_careers.id_turn', 'persons_careers.period_year', 'persons_careers.period_init', 'persons_careers.is_online')
                        ->where('persons.pin', 'like', '%'.$request['document'].'%')
                        ->get();

                    }
                    
        $careers = DB::connection('think_ed')
                    ->table('careers')
                    ->select('id','name')
                    ->where('status', '<>', 0)
                    ->get();
        if ( count($resu) > 1 ) {
            $modal = 1;
            return view('dvhive.maintenance.maintenance', compact('resu', 'modal'));
        } else {
            $user = $resu[0];
            $modal = 0;
            return view('dvhive.maintenance.editStudent', compact('user', 'modal', 'careers'));
        }
    }
    public function updateStudent(){

        dd('guardar cambios');
    }
}

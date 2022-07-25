<?php

namespace App\Http\Controllers\maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\StudentIncidence;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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
       
        $incidence = StudentIncidence::all();
        $modal = 0;
        $resu = 0;
        return view('dvhive.maintenance.maintenance', compact('modal', 'resu', 'incidence'));
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
            $incidence = StudentIncidence::all();
        }
                    
        $careers = DB::connection('think_ed')
                    ->table('careers')
                    ->select('id','name')
                    ->where('status', '<>', 0)
                    ->get();
        if ( count($resu) > 1 ) {
            $modal = 1;
            return view('dvhive.maintenance.maintenance', compact('resu', 'modal', 'incidence'));
        } else {
            $user = $resu[0];
            $modal = 0;
            return view('dvhive.maintenance.editStudent', compact('user', 'modal', 'careers'));
        }
    }
    public function updateStudent(Request $request){
        $aux = DB::connection('think_ed')
                        ->table('persons_careers')
                        ->Select('persons_careers.id_turn', 'persons_careers.period_year', 'persons_careers.period_init', 'persons_careers.is_online')
                        ->where('id_person', '=', $request['id_person'])
                        ->where('id_career', '=', $request['id_career'])
                        ->get();
        $old_data=$aux[0];
        if ($request['observacion'] == '') {
            $observacion = '-- N/A --'."\n".auth()->user()->name;
        } else {
            $observacion = $request['observacion'];
        }
        $incidence = StudentIncidence::create([
                                                'id_person'     => $request['id_person'],
                                                'id_career' => $request['id_career'],
                                                'old_turn'  => $old_data->id_turn,
                                                'old_period_year' => $old_data->period_year,
                                                'old_period_init' => $old_data->period_init,
                                                'old_is_online' => $old_data->is_online,
                                                'new_turn'   => $request->turno,
                                                'new_period_year' => $request->anio,
                                                'new_period_init' => $request->inicio,
                                                'new_is_online' => $request->modalidad,
                                                'observacion' => $observacion,
                                                'user' => auth()->user()->name 
                                            ]);
                        
        $updateReg = DB::connection('think_ed')
                        ->table('persons_careers')
                        ->where('id_person', '=', $request['id_person'])
                        ->where('id_career', '=', $request['id_career'])
                        ->update([
                            'id_turn'   => $request['turno'],  
                            'period_year' => $request['anio'],
                            'period_init' => $request['inicio'],
                            'is_online' => (int)$request['modalidad']
                        ]);

        /*

            #specify the new length of the string
            $len = 8;
            
            #declare number using a string
            $str = "2222";
            echo("Original String \t");
            echo ($str."\n");
            
            #compute new string
            $new_str = str_pad($str,$len,"0", STR_PAD_LEFT);
            echo("Modified String \t");
            echo $new_str;

        */
        /*dd($request, $old_data, $incidence, $updateReg);*/
        return redirect()->route('maintenance');
        
        
    }
}

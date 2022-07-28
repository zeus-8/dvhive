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
       
        $incidence = StudentIncidence::where('status','=', 0)->orderBy('id', 'desc')->get();
        /** HACER EL QUERY ENTRE DOS BASES DE DATOS */
        /*$incidence = DB::table('student_incidence as local')
                            ->join('think.careers as foranea ', 'foranea.id', '=', 'local.id_career')
                            ->select(['local.id', 'local.id_person', 'foranea.name as alumno', 'local.observacion'])
                            //->where('')
                            //->get();
                            ->dd();
        //dd($incidence);*/
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
                                                'observacion' => strtoupper($observacion),
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
    public function rollBackIncidence(Request $request){
        
        $observacion = 'SE REALIZA ROLLBACK '.auth()->user()->name ;
        $incidence = StudentIncidence::where('id', '=', $request['id'])->first();
        
        $intanceNew = StudentIncidence::create([
            'id_person'     => $incidence['id_person'],
            'id_career' => $incidence['id_career'],
            'old_turn'  => $incidence['new_turn'],
            'old_period_year' => $incidence['new_period_year'],
            'old_period_init' => $incidence['new_period_init'],
            'old_is_online' => $incidence['new_is_online'],
            'new_turn'   => $incidence['old_turn'],
            'new_period_year' => $incidence['old_period_year'],
            'new_period_init' => $incidence['old_period_init'],
            'new_is_online' => $incidence['old_is_online'],
            'observacion' => strtoupper($observacion),
            'user' => auth()->user()->name 
        ]);

        StudentIncidence::where('id', $incidence->id)
            ->update(['status' => 1]);
        
        DB::connection('think_ed')
                ->table('persons_careers')
                ->where('id_person', '=', $intanceNew->id_person)
                ->where('id_career', '=', $intanceNew->id_career)
                ->update([
                    'id_turn'   => $intanceNew->new_turn,  
                    'period_year' => $intanceNew->new_period_year,
                    'period_init' => $intanceNew->new_period_init,
                    'is_online' => (int)$intanceNew->new_is_online
                ]);
       

        return redirect()->route('maintenance');
    }
}

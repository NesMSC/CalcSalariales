<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Persona;
use App\Empleado;
use App\Salario;

class empleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $empleados = Persona::join('empleados', 'personas.id' ,'=', 'empleados.persona_id')
                            ->select('nombres', 'apellidos', 'grado', 'nivel', 'departamento')
                            ->get();

        return ["empleados" => $empleados];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{

            DB::beginTransaction();

            $persona = new Persona;
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->cedula = $request->cedula;
            $persona->correo = $request->correo;
            $persona->telefono = $request->telefono;
            $persona->nacimiento = $request->nacimiento;
            $persona->save();

            $empleado = new Empleado;
            $empleado->persona_id = $persona->id;
            $empleado->salario_id = 1;
            $empleado->grado = $request->grado;
            $empleado->nivel = $request->nivel;
            $empleado->fechaIngreso = $request->fecha_ingreso;
            $empleado->departamento = $request->departamento;
            $empleado->instruccion = $request->grado_instruccion;
            $empleado->estado = 'contratado';
            $empleado->save();

            //agregar beneficios
            $beneficios = $request->beneficios;
            for ($i=0; $i < count($beneficios); $i++) { 
                $empleado->beneficio()->attach($beneficios[$i]);
            };

            $descuentos = $request->descuentos;
            for ($i=0; $i < count($descuentos); $i++) { 
                $empleado->descuento()->attach($descuentos[$i]);
            };

            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            return $e;
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function salarioTabla(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id_salario = $request->id_salario;

        $salario = Salario::join("ind_economicos", "salarios.indicador_id", "=", "ind_economicos.id")              ->select('tabulador', 'UnTributaria')
                          ->where('salarios.id', '=', $id_salario)
                          ->get();

        return ["tabulador"=>$salario[0]->tabulador, "UT"=>$salario[0]->UnTributaria];
    }
    public function beneficios(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $beneficios = DB::table('beneficios')->get();

        return ["beneficios" => $beneficios];
    }


    public function primaProfesional(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $json = file_get_contents('json/primaProfesional.json');
        $json_primas=json_decode($json);

        $prima = DB::table('beneficios')
                      ->select('id', 'concepto', 'tipo_valor', 'valor')
                      ->where('valor', '=', 0)
                      ->get();

        return ["primaProfesional" => $json_primas, "prima" => $prima];
    }

    public function primaAntiguedad(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $prima = DB::table('beneficios')
                      ->select('id')
                      ->where('concepto', '=', 'Prima de Antiguedad')
                      ->get();

        return ["primaAntiguedad" => $prima];
    }

    public function descuentos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $descuentos = DB::table('descuentos')->get();

        return ["descuentos" => $descuentos];
    }
}

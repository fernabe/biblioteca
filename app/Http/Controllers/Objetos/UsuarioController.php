<?php

namespace App\Http\Controllers\Objetos;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){
            $usuarios = User::all();
            return response()->json($usuarios);
        }else{
            return redirect('/home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( $request->ajax() ){
            $this->validate(request(), [

            'nombre' => 'required|max:255',
            'apellido1' => 'required|max:255',
            'apellido2' => 'required|max:255',
            'dni' => 'required|size:9|max:255|is_valid_dni|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'telefono' => 'required|digits:9|numeric',
            'direccion' => 'required|max:255',
            'poblacion' => 'required|max:255',

            ]);

            $usuario = new User;

            $usuario->nombre = request('nombre');
            $usuario->apellido1 = request('apellido1');
            $usuario->apellido2 = request('apellido2');
            $usuario->dni = request('dni');
            $usuario->email = request('email');
            $usuario->telefono = request('telefono');
            $usuario->direccion = request('direccion');
            $usuario->poblacion = request('poblacion');
            $password = $this->generatePass();
            $usuario->password = bcrypt($password);

            $usuario->save();

            return response()->json(['correcto' => true, 'password'=> $password, 'mensaje' => 'Usuario guardado en la base de datos'],200);

        }else{
            return redirect('/home');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if( $request->ajax() ){
            $usuario = User::find($id);
            $usuario->reservas = $this->getReservas($id);
            $usuario->prestamos = $this->getPrestamos($id);
            $usuario->retrasos = $this->getRetrasos($id);
            return response()->json($usuario);
        }else{
            return redirect('/home');
        }
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
        if( $request->ajax() ){

            $verdad = false;//Variable que controla si se ha introducido una nueva contraseña, si es falso mantendrá la que hay y sino la cambiara por la nueva introducida

            $datos_actuales = DB::table('users')
                ->select('email','password')
                ->where('id',$id)
                ->get();

            if( $request->input('password') != ''){
                $this->validate(request(), [
                    'password' => 'min:6|confirmed'
                ]);
                $password = $request->input('password');
                $verdad = true;
            }else{
                $password = $datos_actuales[0]->password;
            }

            if($datos_actuales[0]->email == $request->input('email')){

                $this->validate(request(), [
                'nombre' => 'required|max:255',
                'apellido1' => 'required|max:255',
                'apellido2' => 'required|max:255',
                'dni' => 'required|size:9|max:255|is_valid_dni',
                'telefono' => 'required|digits:9|numeric',
                'direccion' => 'required|max:255',
                'poblacion' => 'required|max:255',
                ]);

                $email_guardar = $datos_actuales[0]->email;

            }else{

                $this->validate(request(), [
                'nombre' => 'required|max:255',
                'apellido1' => 'required|max:255',
                'apellido2' => 'required|max:255',
                'dni' => 'required|size:9|max:255|is_valid_dni',
                'email' => 'required|email|max:255|unique:users',
                'telefono' => 'required|digits:9|numeric',
                'direccion' => 'required|max:255',
                'poblacion' => 'required|max:255',
                ]);

                $email_guardar = response()->input('email');
            }
            
            DB::table('users')
                ->where('id',$id)
                ->update([
                    'nombre' => $request->input('nombre'),
                    'apellido1' => $request->input('apellido1'),
                    'apellido2' => $request->input('apellido2'),
                    'dni' => $request->input('dni'),
                    'email' => $email_guardar,
                    'telefono' => $request->input('telefono'),
                    'direccion' => $request->input('direccion'),
                    'poblacion' => $request->input('poblacion'),
                    'password' => $verdad ? bcrypt($password) : $password,
            ]);

            return response()->json(['respuesta'=>'OK'],200);

        }else{
            return redirect('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if( $request->ajax() ){

            if( $this->getPrestamos($id) + $this->getReservas($id) + $this->getRetrasos($id) == 0){
        
                $usuario = User::find($id);
                $usuario->delete();

                return response()->json(['correcto' => true, 'mensaje' => 'Usuario eliminado con éxito.'],200);
            }else{
                return response()->json(['correcto' => false, 'mensaje' => 'No se puede eliminar al usuario porque tiene reservas, préstamos o retrasos pendientes.'],200);
            }

        }else{
            return redirect('/home');
        }
    }

    private function generatePass(){

        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

        $longitudCadena=strlen($cadena);
     
        $pass = "";
    
        $longitudPass=8;
     
        
        for($i=1 ; $i<=$longitudPass ; $i++){
            
            $pos=rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }

        return $pass;
    }

    private function getReservas($id){

        $reservas = DB::table('reservas')
                        ->where('id_usuario', $id)
                        ->get();

        return count($reservas);

    }

    private function getPrestamos($id){

        $prestamos = DB::table('prestamos')
                        ->where('id_usuario', $id)
                        ->get();

        return count($prestamos);
    }

    private function getRetrasos($id){

        $retrasos = DB::table('retrasos')
                        ->where('id_usuario', $id)
                        ->get();

        return count($retrasos);
    }

}

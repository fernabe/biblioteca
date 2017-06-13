<?php

namespace App\Http\Controllers\Objetos;

use App\Reserva;
use App\Retraso;
use App\Prestamo;
use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()){

            $reservas = DB::table('reservas')
            ->join('users', 'reservas.id_usuario', '=', 'users.id')
            ->join('books', 'reservas.id_libro', '=', 'books.id')
            ->select('reservas.*', 'users.nombre', 'users.apellido1','users.apellido2','users.email','users.dni','books.titulo','books.autor','books.editorial','books.isbn')
            ->get();

            return response()->json($reservas);
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

            $id_usuario = $request->input('id_usuario');
            $id_libro = $request->input('id_libro');

            $ejemplares_libro = $this->obtenerEjemplares($id_libro);

            $libros_prestados = $this->obtenerPrestados($id_libro);

            $disponibles = $ejemplares_libro[0]->ejemplares - $libros_prestados;

            if( $this->obtenerRetrasosUsuario($id_usuario) == 0){

                if( $disponibles > 0){

                    $prestamos = $this->obtenerPrestamos($id_usuario,$id_libro);
                    $reservas = $this->obtenerReservas($id_usuario,$id_libro);

                    if($prestamos == 0 && $reservas == 0){

                        $reserva = new Reserva;
                        $reserva->id_usuario = request('id_usuario');
                        $reserva->id_libro = request('id_libro');
                        $reserva->fecha_reserva = date('Y-m-d');
                        $fin = time() + (7*24*60*60);
                        $reserva->fin_reserva = date('Y-m-d',$fin);
                        $reserva->save();

                        return response()->json([ 'correcto' => true, 'mensaje' => 'Reserva realizada'],200);

                    }else{
                        if( $prestamos > 0){
                            return response()->json([ 'correcto' => false, 'mensaje' => 'No puedes reservar este libro, ya se encuentra en tus préstamos.'],200);
                        }else{
                            return response()->json([ 'correcto' => false, 'mensaje' => 'No puedes reservar este libro, ya se encuentra en tus reservas.'],200);
                        }  
                    }

                }else{
                    return response()->json(['correcto' => false, 'mensaje' => 'No pudes reservar este libro. No quedan ejemplares disponibles en la biblioteca.'],200);
                }

            }else{
                return response()->json(['correcto' => false, 'mensaje' => 'No puedes reservar ningún libro, ya que tienes retrasos en tus prestamos.'],200);
            }

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
    
        if($request->ajax()){

            $reservas = DB::table('reservas')
            ->join('users', function($join){
                $join->on('reservas.id_usuario', '=', 'users.id');
            })
            ->join('books', 'reservas.id_libro', '=', 'books.id')
            ->select('reservas.*', 'users.nombre', 'users.apellido1','users.apellido2','users.email','users.dni','books.titulo','books.autor','books.editorial','books.isbn')
            ->where('users.id', '=', $id)
            ->get();

            return response()->json($reservas);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if( $request->ajax()){
            $reserva = Reserva::find($id);
            $reserva->delete();
        }else{
            return redirect('home');
        }
        
    }

    private function obtenerRetrasosUsuario($id){
         $retrasos = DB::table('retrasos')
                        ->where('id_usuario', $id)
                        ->get();
        return count($retrasos);

    }

    private function obtenerPrestamos($id_usuario,$id_libro){

        $prestamos = DB::table('prestamos')
                        ->where('id_usuario', $id_usuario)
                        ->where('id_libro', $id_libro)
                        ->get();
        return count($prestamos);
    }

    private function obtenerReservas($id_usuario,$id_libro){

        $reservas = DB::table('reservas')
                        ->where('id_usuario', $id_usuario)
                        ->where('id_libro', $id_libro)
                        ->get();
        return count($reservas);
    }

    private function obtenerEjemplares($id_libro){

        $ejemplares = DB::table('books')->select('ejemplares')
                    ->where('id', $id_libro)
                    ->get();
        return $ejemplares;

    }

    private function obtenerPrestados($id_libro){

        $reservas = DB::table('reservas')
                        ->where('id_libro', $id_libro)
                        ->get();

        $reservas = count($reservas);

        $prestamos = DB::table('prestamos')
                        ->where('id_libro', $id_libro)
                        ->get();

        $prestamos = count($prestamos);

        $retrasos = DB::table('retrasos')
                        ->where('id_libro', $id_libro)
                        ->get();

        $retrasos = count($retrasos);

        return $reservas + $retrasos + $prestamos;

    }
}

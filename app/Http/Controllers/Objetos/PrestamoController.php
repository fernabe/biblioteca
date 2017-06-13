<?php

namespace App\Http\Controllers\Objetos;

use App\Prestamo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $reservas = DB::table('prestamos')
            ->join('users', 'prestamos.id_usuario', '=', 'users.id')
            ->join('books', 'prestamos.id_libro', '=', 'books.id')
            ->select('prestamos.*', 'users.nombre', 'users.apellido1','users.apellido2','users.email','users.dni','books.titulo','books.autor','books.editorial','books.isbn')
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

            if( $request->input('reserva')){

                $prestamo = new Prestamo;

                $prestamo->id_usuario = request('id_usuario');
                $prestamo->id_libro = request('id_libro');
                $prestamo->fecha_prestamo = date('Y-m-d');
                $fin = time() + (20*24*60*60);
                $prestamo->fin_prestamo = date('Y-m-d', $fin);
                $prestamo->renovaciones = 0;

                $prestamo->save();

                return response()->json([ 'correcto' => true, 'mensaje' => 'Prestamo realizado'],200);

            }else{

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

                        $prestamo = new Prestamo;
                        $prestamo->id_usuario = request('id_usuario');
                        $prestamo->id_libro = request('id_libro');
                        $prestamo->fecha_prestamo = date('Y-m-d');
                        $fin = time() + (19*24*60*60);
                        $prestamo->fin_prestamo = date('Y-m-d',$fin);
                        $prestamo->renovaciones = 0;
                        $prestamo->save();

                        return response()->json([ 'correcto' => true, 'mensaje' => 'Prestamo realizado.'],200);

                        }else{
                            if( $prestamos > 0){
                                return response()->json([ 'correcto' => false, 'mensaje' => 'No se puede realizar el préstamo, ya tienes prestado el libro.'],200);
                            }else{
                                return response()->json([ 'correcto' => false, 'mensaje' => 'No se puede realizar el préstamo, ya tienes reservado el libro.'],200);
                            }  
                        }

                    }else{
                        return response()->json(['correcto' => false, 'mensaje' => 'No se puede realizar el préstamo. No quedan ejemplares disponibles en la biblioteca.'],200);
                    }

                }else{
                    return response()->json(['correcto' => false, 'mensaje' => 'No te podemos prestar ningun libro, ya que tienes retrasos en tus préstamos.'],200);
                }
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

            $prestamos = DB::table('prestamos')
            ->join('users', function($join){
                $join->on('prestamos.id_usuario', '=', 'users.id');
            })
            ->join('books', 'prestamos.id_libro', '=', 'books.id')
            ->select('prestamos.*', 'users.nombre', 'users.apellido1','users.apellido2','users.email','users.dni','books.titulo','books.autor','books.editorial','books.isbn')
            ->where('users.id', '=', $id)
            ->get();

            return response()->json($prestamos);

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

                $datos = DB::table('prestamos')->select('fin_prestamo','renovaciones')
                            ->where('id', $id)
                            ->get();

                $renovaciones = $datos[0]->renovaciones;

                if($renovaciones < 2 ){

                    $fecha = $datos[0]->fin_prestamo;

                    $nuevaFecha = date('Y-m-d', strtotime($fecha) + (10*24*60*60));

                    DB::table('prestamos')
                        ->where('id',$id)
                        ->update([
                            'fin_prestamo' => $nuevaFecha,
                            'renovaciones' => $renovaciones+1,
                    ]);

                        return response()->json(['correcto' => true, 'mensaje'=> 'El préstamo del libro se ha renovado por diez días mas.'],200);

                }else{
                    return response()->json(['correcto' => false, 'mensaje' => 'No puedes renovar el préstamo, has agotado las renovaciones.'],200);
                }
                
            }else{
                return redirect('/home');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if( $request->ajax() ){
            $prestamo = Prestamo::find($id);
            $prestamo->delete();
            return response()->json(['correcto'=> 'true', 'mensaje' => 'El libro ha sido devuelto.'],200);
        }else{
            return redirect('/home');
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

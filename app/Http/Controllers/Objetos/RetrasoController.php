<?php

namespace App\Http\Controllers\Objetos;

use App\Retraso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RetrasoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){

            $prestamos = DB::table('retrasos')
                ->join('books', 'retrasos.id_libro', '=', 'books.id')
                ->join('users', 'retrasos.id_usuario', '=', 'users.id')
                ->select('retrasos.*', 'users.nombre', 'users.apellido1','users.apellido2','users.email','users.dni','books.titulo','books.autor','books.editorial','books.isbn')
                ->get();
             return response()->json($prestamos);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if( $request->ajax() ){
          
            $prestamos = DB::table('retrasos')
                ->join('books', 'retrasos.id_libro', '=', 'books.id')
                ->join('users', 'retrasos.id_usuario', '=', 'users.id')
                ->select('retrasos.*', 'users.nombre', 'users.apellido1','users.apellido2','users.email','users.dni','books.titulo','books.autor','books.editorial','books.isbn')
                ->where('id_usuario', $id)
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
        if( $request->ajax() ){
            $retraso = Retraso::find($id);
            $retraso->delete();
            return response()->json(['correcto' => true, 'mensaje' => 'El libro ha sido devuelto.'],200);
        }else{
            return redirect('/home');
        }
    }
}

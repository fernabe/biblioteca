<?php

namespace App\Http\Controllers\Objetos;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
        if($request->ajax()){
            $libros = Book::all();
            return response()->json($libros);
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
            'titulo' => 'required|max:255',
            'autor' => 'required|max:255',
            'editorial' => 'required|max:255',
            'isbn' => 'required|numeric|digits:13|unique:books',
            'paginas' => 'required|numeric',
            'ejemplares' => 'required|numeric',
            ]);

            $libro = new Book;

            $libro->titulo = request('titulo');
            $libro->autor = request('autor');
            $libro->editorial = request('editorial');
            $libro->isbn = request('isbn');
            $libro->paginas = request('paginas');
            $libro->ejemplares = request('ejemplares');

            $libro->save();

            return response()->json(['correcto'=> true, 'mensaje'=>'Libro añadido a la base de datos.'],200);

        }else{
            return redirect('/home');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if( $request->ajax() ){
            $libro = Book::find($id);
            //Establecemos el numero de libros prestados, reservados o retrasados, para obtener si hay disponibles.
            $prestados = $this->getPrestamos($id) + $this->getReservas($id) + $this->getRetrasos($id);
            $libro->disponibles = $libro->ejemplares - $prestados;//Añadimos los ejemplares disponibles
            return response()->json($libro);
        }else{
            return redirect('/home');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if( $request->ajax() ){

            $datos_actuales = DB::table('books')
                ->select('isbn')
                ->where('id',$id)
                ->get();

            if( $request->input('isbn') == $datos_actuales[0]->isbn ){
                $this->validate(request(), [
                    'titulo' => 'required|max:255',
                    'autor' => 'required|max:255',
                    'editorial' => 'required|max:255',
                    'paginas' => 'required|numeric',
                    'ejemplares' => 'required|numeric',
                ]);

            }else{
                 $this->validate(request(), [
                    'titulo' => 'required|max:255',
                    'autor' => 'required|max:255',
                    'editorial' => 'required|max:255',
                    'isbn' => 'required|numeric|digits:13|unique:books',
                    'paginas' => 'required|numeric',
                    'ejemplares' => 'required|numeric',
                ]);
            }
           

            DB::table('books')
                ->where('id',$id)
                ->update([
                    'titulo' => $request->input('titulo'),
                    'autor' => $request->input('autor'),
                    'editorial' => $request->input('editorial'),
                    'isbn' => $request->input('isbn'),
                    'paginas' => $request->input('paginas'),
                    'ejemplares' => $request->input('ejemplares'),
            ]);

            return response()->json(['correcto' => true, 'mensaje' => 'Información del libro actualizada.'],200);

        }else{
            return redirect('/home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if( $request->ajax() ){

            if( $this->getPrestamos($id) + $this->getReservas($id) + $this->getRetrasos($id) == 0){
        
                $usuario = Book::find($id);
                $usuario->delete();

                return response()->json(['correcto' => true, 'mensaje' => 'Libro eliminado con éxito.'],200);
            }else{
                return response()->json(['correcto' => false, 'mensaje' => 'No se puede eliminar este libro porque tiene reservas, préstamos o retrasos pendientes.'],200);
            }

        }else{
            return redirect('/home');
        }
    }


    /**Funcion que establece el numero de reservas de un libro**/
    private function getReservas($id){

        $reservas = DB::table('reservas')
                        ->where('id_libro', $id)
                        ->get();

        return count($reservas);
    }

    /**Funcion que establece el numero de prestamos de un libro**/
    private function getPrestamos($id){

        $prestamos = DB::table('prestamos')
                        ->where('id_libro', $id)
                        ->get();

          return count($prestamos);
    }

    /**Funcion que establece el numero de retrasos de un libro**/
    private function getRetrasos($id){

        $retrasos = DB::table('retrasos')
                        ->where('id_libro', $id)
                        ->get();

        return count($retrasos);
    }

}

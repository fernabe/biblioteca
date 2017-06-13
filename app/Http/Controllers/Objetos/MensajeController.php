<?php

namespace App\Http\Controllers\Objetos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Reserva;
use App\Prestamo;
use App\Retraso;

class MensajeController extends Controller
{

    /**Muestra un mensaje cuando hay una reserva que finaliza el dia actual**/
    public function showMensajesReservasFin(Request $request,$id){

    	if( $request->ajax()){

    		$fecha = date('Y-m-d');

			$reservas = DB::table('reservas')
                ->join('books', 'reservas.id_libro', '=', 'books.id')
                ->select('books.titulo')
                ->where('id_usuario', $id)
                ->where('fin_reserva',$fecha)
                ->get();

            return response()->json($reservas);
    	}else{
            return redirect('/home');
        }
    }

    /**Muestra un mensaje cuando hay un prestamo que finaliza el dia actual**/
    public function showMensajesPrestamosFin(Request $request,$id){

    	if( $request->ajax()){

    		$fecha = date('Y-m-d');

			$prestamos = DB::table('prestamos')
                ->join('books', 'prestamos.id_libro', '=', 'books.id')
                ->select('books.titulo')
                ->where('id_usuario', $id)
                ->where('fin_prestamo',$fecha)
                ->get();

            return response()->json($prestamos);
    	}else{
            return redirect('/home');
        }
    }

    /**Muestra si hay alguna reserva caducada o si se han eliminado las reservas por tener algun retraso*/
    public function showReservasCaducadas(Request $request,$id){

        if( $request->ajax()){

             $reservas_caducadas = DB::table('avisos')
                ->join('books', 'avisos.id_libro', '=', 'books.id')
                ->select('books.titulo','avisos.tipo')
                ->where('id_usuario', $id)
                ->get();

            return response()->json($reservas_caducadas);
        }else{
            return redirect('/home');
        }
    }

    /*Una vez mostrado los mensajes actualiza la tabla avisos poniendo los mensajes a leidos, para que sean eliminados por los eventos de mysql**/
    public function actualizarAvisos(Request $request,$id){
        if($request->ajax()){
            DB::table('avisos')
                        ->where('id_usuario',$id)
                        ->where('visto',0)
                        ->update(['visto' => 1]);
            return response()->json(['respuesta' => true],200);
        }else{
            return redirect('home');
        }
    }
}

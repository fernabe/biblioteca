<?php

namespace App\Http\Controllers\Mail;

use App\Mail\EnvioPass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class EnvioPassController extends Controller
{
    /**
     * Ship the given order.
     *
     * @param  Request  $request
     * @param  int  $orderId
     * @return Response
     */
    public function ship(Request $request)
    {
    	
 		Mail::to( $request->input('email') )->send(new EnvioPass($request->input('email'), $request->input('nombre'), $request->input('apellido1'), $request->input('password')));

    	return response()->json([ $request->input('email'), $request->input('nombre'), $request->input('apellido1'), $request->input('password') ]);
    }
}

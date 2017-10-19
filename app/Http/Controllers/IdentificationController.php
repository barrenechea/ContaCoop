<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Identification;

class IdentificationController extends Controller
{
    public function new(Request $request)
    {
        $rut = $request->input('rut');
        $name = $request->input('name');

        $identification = new Identification();
        $identification->rut = $rut;
        $identification->name = $name;

        if($identification->save())
        {
            $this->addlog('Agregó nuevo RUT: ' . $identification->rut . ' - ' . $identification->name);
            $request->session()->flash('success', 'El RUT ha sido ingresado exitosamente');
        }
        else
            $request->session()->flash('warning', 'El RUT no ha podido ser ingresado');
        
        return redirect()->back();
    }

    public function list(Request $request)
    {
    	if($request->input('find'))
    		$identifications = Identification::where('name', 'LIKE', '%' . $request->input('find') . '%')->get();
    	else
    		$identifications = Identification::paginate(20);
        
    	return view('list.identifications', ['identifications' => $identifications, 'find' => $request->input('find')]);
    }

    public function update(Request $request)
    {
        $id = intval($request->input('identification_id'));
        $name = $request->input('name');
        $rut = $request->input('rut');

        $identification = Identification::find($id);
        if($identification)
        {
            $identification->name = $name;
            $identification->rut = $rut;
            if($identification->save())
            {
                $this->addlog('Actualizó RUT: ' . $identification->rut . ' - ' . $identification->name);
                $request->session()->flash('success', 'El RUT ha sido actualizado exitosamente');
            }
            else
                $request->session()->flash('warning', 'El RUT no ha podido ser actualizado');
        }
        else
            $request->session()->flash('warning', 'El RUT no se ha encontrado');
        
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = $request->input('identification');
        $identification = Identification::find($id);
        if($identification && $identification->delete())
        {
            $this->addlog('Eliminó RUT: ' . $identification->rut . ' - ' . $identification->name);
            $request->session()->flash('success', 'El RUT ha sido eliminado exitosamente');
        }
        else
            $request->session()->flash('warning', 'El RUT no ha podido ser eliminado');
        
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Bank;

class BankController extends Controller
{
    public function new(Request $request)
    {
        $name = $request->input('name');
        $checking_account = $request->input('checking_account');
        $account_id = $request->input('account_id');
        $checkact = $request->input('checkact');

        $bank = new Bank();
        $bank->name = $name;
        $bank->checking_account = $checking_account;
        $bank->account_id = $account_id;
        $bank->checkact = $checkact;

        if($bank->save())
        {
            $this->addlog('Agregó nuevo banco: ' . $bank->checking_account . ' - ' . $bank->name);
            $request->session()->flash('success', 'El banco ha sido ingresado exitosamente');
        }
        else
            $request->session()->flash('warning', 'El banco no ha podido ser ingresado');
        
        return redirect()->back();
    }

    public function list(Request $request)
    {
    	if($request->input('find')){
    		$banks = Bank::where('name', 'LIKE', '%' . $request->input('find') . '%')->get();
    		if($banks->count() == 0)
    			$banks = Bank::where('checking_account', 'LIKE', '%' . $request->input('find') . '%')->get();
    	}
    	else
    		$banks = Bank::paginate(20);
        
    	return view('list.banks', ['banks' => $banks, 'find' => $request->input('find')]);
    }

    public function update(Request $request)
    {
        $id = intval($request->input('bank_id'));
        $name = $request->input('name');
        $checking_account = $request->input('checking_account');
        $account_id = $request->input('account_id');
        $checkact = $request->input('checkact');

        $bank = Bank::find($id);
        if($bank)
        {
            $bank->name = $name;
            $bank->checking_account = $checking_account;
            $bank->account_id = $account_id;
            $bank->checkact = $checkact;
            if($bank->save())
            {
                $this->addlog('Actualizó banco: ' . $bank->checking_account . ' - ' . $bank->name);
                $request->session()->flash('success', 'El banco ha sido actualizado exitosamente');
            }
            else
                $request->session()->flash('warning', 'El banco no ha podido ser actualizado');
        }
        else
            $request->session()->flash('warning', 'El banco no se ha encontrado');
        
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = $request->input('bank');
        $bank = Bank::find($id);
        if($bank && $bank->delete())
        {
            $this->addlog('Eliminó banco: ' . $bank->checking_account . ' - ' . $bank->name);
            $request->session()->flash('success', 'La cuenta bancaria ha sido eliminada exitosamente');
        }
        else
            $request->session()->flash('warning', 'La cuenta bancaria no ha podido ser eliminada');
        
        return redirect()->back();
    }
}

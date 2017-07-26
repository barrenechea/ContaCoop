<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountController extends Controller
{
    public function new(Request $request)
    {
        $father_account = Account::find(intval($request->input('father_account_id')));
        $fecucode = $request->input('fecucode_id');
        $name = $request->input('name');
        $cc = $request->input('cc');
        $rut = $request->input('rut');
        $flu = $request->input('flu');
        $patr = $request->input('patr');

        // Obtener valor de cuenta contable que viene, según el código del padre
        $exploded_code = explode('-', $father_account->codigo);
        $higherAccount = Account::withTrashed()->where('nivel', 4)->where('codigo', 'LIKE', $exploded_code[0].'-'.$exploded_code[1].'%')->orderBy('codigo', 'desc')->first();
        if($higherAccount)
            $nextVal = $exploded_code[0] . '-' . $exploded_code[1] . '-' . str_pad((intval(explode('-', $higherAccount->codigo)[2]) + 1), 3, '0', STR_PAD_LEFT);
        else
            $nextVal = $exploded_code[0] . '-' . $exploded_code[1] . '-001';
        // End obtener valor de cuenta contable que viene, según el código del padre

        $account = new Account();
        $account->codigo = $nextVal;
        if($fecucode)
            $account->fecucode_id = intval($fecucode);
        $account->clase = $father_account->clase;
        $account->nivel = 4;
        $account->ctacte = $cc ? 'S' : 'N';
        $account->ctacte2 = $rut ? 'S' : 'N';
        $account->ctacte3 = $flu ? 'S' : 'N';
        $account->ctacte4 = $patr ? 'S' : 'N';
        $account->nombre = strtoupper($name);

        if($account->save())
            $request->session()->flash('success', 'La cuenta contable ha sido ingresada exitosamente');
        else
            $request->session()->flash('warning', 'La cuenta contable no ha podido ser ingresada');
        
        return redirect()->back();
    }

    public function list(Request $request)
    {
        if($request->input('find')){
            $accounts = Account::where('nombre', 'LIKE', '%' . $request->input('find') . '%')->orderBy('codigo', 'asc')->get();
            if($accounts->count() == 0)
                $accounts = Account::where('codigo', 'LIKE', '%' . $request->input('find') . '%')->orderBy('codigo', 'asc')->get();
        }
        else
            $accounts = Account::orderBy('codigo', 'asc')->paginate(20);
        
        return view('list.accounts', ['accounts' => $accounts, 'find' => $request->input('find')]);
    }

    public function update(Request $request)
    {
        $id = intval($request->input('account_id'));
        $fecucode = $request->input('fecucode_id');
        $name = $request->input('name');
        $cc = $request->input('cc');
        $rut = $request->input('rut');
        $flu = $request->input('flu');
        $patr = $request->input('patr');

        $account = Account::find($id);
        if($account)
        {
            if($fecucode)
                $account->fecucode_id = intval($fecucode);
            else
                $account->fecucode_id = null;
            $account->ctacte = $cc ? 'S' : 'N';
            $account->ctacte2 = $rut ? 'S' : 'N';
            $account->ctacte3 = $flu ? 'S' : 'N';
            $account->ctacte4 = $patr ? 'S' : 'N';
            $account->nombre = strtoupper($name);

            if($account->save())
                $request->session()->flash('success', 'La cuenta contable ha sido actualizada exitosamente');
            else
                $request->session()->flash('warning', 'La cuenta contable no ha podido ser actualizada');
        }
        else
            $request->session()->flash('warning', 'La cuenta contable no se ha encontrado');
        
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = $request->input('account');
        $account = Account::find($id);
        if($account && $account->delete())
            $request->session()->flash('success', 'La cuenta contable ha sido eliminada exitosamente');
        else
            $request->session()->flash('warning', 'La cuenta contable no ha podido ser eliminada');
        
        return redirect()->back();
    }
}

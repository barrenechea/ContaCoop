<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Account;
use App\Identification;
use App\Voucher;
use App\Voucherdetail;
use App\Bank;
use Image;

use Carbon\Carbon;

class VoucherController extends Controller
{
    public function viewVoucher($type, $sequence)
    {
        $id = explode('-', $sequence);
        $voucher = Voucher::where('type', $type)->where('sequence', $id[0])->whereYear('date', $id[1])->first();
        return view('voucher.voucher', ['voucher' => $voucher]);
    }

    public function searchVoucher(Request $request)
    {
        $id = $request->input('code');
        $year = $request->input('year');
        $type = $request->input('type');

        $voucher = Voucher::where('type', $type)->where('sequence', $id)->whereYear('date', $year)->first();

        if(!$voucher)
            return redirect()->back()->withErrors(['No se han encontrado registros en la búsqueda.']);

        return redirect('/view/voucher/' . $type . '/' . $id . '-' . $year);
    }

    public function newIncomeGet()
    {
        $auxVoucher = Voucher::where('type', 'I')->whereYear('date', '=', Carbon::now()->year)->orderBy('id', 'desc')->first();
        if($auxVoucher)
            $correl = $auxVoucher->sequence + 1;
        else
            $correl = 1;
        $accounts = Account::where('nivel', 4)->orderBy('codigo', 'asc')->get();
        $identifications = Identification::all();
    	return view('new.voucher.income', ['accounts' => $accounts, 'identifications' => $identifications, 'correl' => $correl]);
    }

    public function newIncomePost(Request $request)
    {
        $accounts = [];
        $ruts = [];
        $nombres = [];
        $string_nombres = [];
        $detalles = [];
        $doctype_ids = [];
        $doc_numbers = [];
        $fechas = [];
        $deberes = [];
        $haberes = [];

        // Recuperar valores desde el request
        $tipo = 'I';
        $auto_correl = $request->input('auto_correl');
        $sync = $request->input('sync');
        $date = $request->input('date');
        $date = Carbon::createFromDate(intval(explode('-', $date)[2]),intval(explode('-', $date)[1]),intval(explode('-', $date)[0]));
        $description = $request->input('description');

        for($i = 1; $i <= 10; $i++)
        {
            $accounts[] = intval($request->input('account'.$i)); // Id's de objeto Account
            $ruts[] = $request->input('rut'.$i); // Sólo estará lleno algún campo si no existe un Identification
            $nombres[] = intval($request->input('nombre'.$i)); // Id's de objeto Identification
            $string_nombres[] = $request->input('string_nombre'.$i);
            $detalles[] = $request->input('detalle'.$i);
            $doctype_ids[] = $request->input('doctype_id'.$i);
            $doc_numbers[] = $request->input('doc_number'.$i);
            $fechas[] = $request->input('fecha'.$i);
            $deberes[] = intval($request->input('debe'.$i));
            $haberes[] = intval($request->input('haber'.$i));
        }
        // End recuperar valores desde el request

        // Validar que al menos se llenaron dos lineas del voucher
        $count = 0;
        for($i = 0; $i < 10; $i++)
        {
            if(!$accounts[$i]) continue;
            $count++;
        }
        if($count < 2)
            return redirect()->back()->withErrors(['Debe llenar al menos dos líneas del voucher.']);
        // End validar que al menos se llenaron dos lineas del voucher

        if($auto_correl){
            $auxVoucher = Voucher::where('type', $tipo)->whereYear('date', '=', $date->year)->orderBy('id', 'desc')->first();
            if($auxVoucher){
                $val = $auxVoucher->sequence;
                $correl = $val + 1;
            }else{
                $correl = 1;
            }
        }
        else
            $correl = intval($request->input('correl'));

        // Verificación que el correlativo no exista, sino buscar hasta que encuentre uno libre
        while(true){
            if(Voucher::where('type', $tipo)->where('sequence', $correl)->count())
                $correl++;
            else
                break;
        }
        // End verificación que el correlativo no exista, sino buscar hasta que encuentre uno libre

        // Generar un objeto Voucher y guardarlo en la base de datos
        $voucher = new Voucher();
        $voucher->type = $tipo;
        $voucher->sequence = $correl;
        $voucher->date = $date;
        $voucher->description = $description;
        if($sync)
            $voucher->wants_sync = true;

        // Guardar imagen en servidor
        if($request->hasFile('img'))
        {
            $img = $request->file('img');

            $filename = time() . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(null, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save( public_path('/uploads/imgs/' . $filename ) );

            $voucher->img = $filename;
            // End guardar imagen en servidor
        }

        $voucher->save();
        // End generar un objeto Voucher y guardarlo en la base de datos

        // Comenzar a validar líneas del voucher
        for($i = 0; $i < 10; $i++)
        {
            $identification = null;
            // Validar si la línea actual posee una cuenta contable, de lo contrario se saltará
            if(!$accounts[$i]) continue;
            $account = Account::find($accounts[$i]);
            if(!$account) continue;
            // End validar si la línea actual posee una cuenta contable, de lo contrario se saltará

            if($account->ctacte2 == 'S'){
                // Identificar el RUT / Nombre ingresados
                if($nombres[$i] && $nombres[$i] != 0){
                    $identification = Identification::find($nombres[$i]);
                }elseif ($ruts[$i] && $string_nombres[$i]) {
                    // Validación extra, en caso de RUT nuevo en multiples lineas
                    $identification = Identification::where('rut', $ruts[$i])->first();
                    if(!$identification)
                    {
                        // Generar nuevo Identification
                        $identification = new Identification();
                        $identification->rut = $ruts[$i];
                        $identification->name = $string_nombres[$i];
                        $identification->save();
                        // End generar nuevo Identification
                    }
                }
                // End identificar el RUT / Nombre ingresados 
            }
            // Generar Voucherdetail
            $voucherdetail = new Voucherdetail();
            $voucherdetail->voucher_id = $voucher->id;
            $voucherdetail->account_id = $account->id;
            if($account->ctacte2 == 'S')
                $voucherdetail->identification_id = $identification->id;
            $voucherdetail->detail = $detalles[$i];
            if($doctype_ids[$i])
                $voucherdetail->doctype_id = $doctype_ids[$i];
            if($doc_numbers[$i])
                $voucherdetail->doc_number = $doc_numbers[$i];
            $doctype_ids[] = $request->input('doctype_id'.$i);
            $doc_numbers[] = $request->input('doc_number'.$i);

            $voucherdetail->date = Carbon::createFromDate(intval(explode('-', $fechas[$i])[2]),intval(explode('-', $fechas[$i])[1]),intval(explode('-', $fechas[$i])[0]));
            $voucherdetail->debit = $deberes[$i];
            $voucherdetail->credit = $haberes[$i];

            $voucherdetail->save();
            // End generar Voucherdetail
        }
        $this->addlog('Generó nuevo voucher de Ingreso: ' . $voucher->sequence . '-' . $voucher->date->year);
        $request->session()->flash('success', 'El voucher ha sido generado exitosamente');
        return redirect('/view/voucher/' . $tipo . '/' . $voucher->sequence . '-' . $voucher->date->year);
    }

    public function newOutcomeGet()
    {
        $auxVoucher = Voucher::where('type', 'E')->whereYear('date', '=', Carbon::now()->year)->orderBy('id', 'desc')->first();
        if($auxVoucher)
            $correl = $auxVoucher->sequence + 1;
        else
            $correl = 1;
        $accounts = Account::where('nivel', 4)->orderBy('codigo', 'asc')->get();
        $identifications = Identification::all();
        $banks = Bank::all();
        return view('new.voucher.outcome', ['accounts' => $accounts, 'identifications' => $identifications, 'banks' => $banks, 'correl' => $correl]);
    }

    public function newOutcomePost(Request $request)
    {
        $accounts = [];
        $ruts = [];
        $nombres = [];
        $string_nombres = [];
        $detalles = [];
        $doctype_ids = [];
        $doc_numbers = [];
        $fechas = [];
        $deberes = [];
        $haberes = [];

        // Recuperar valores desde el request
        $tipo = 'E';
        $auto_correl = $request->input('auto_correl');
        $date = $request->input('date');
        $date = Carbon::createFromDate(intval(explode('-', $date)[2]),intval(explode('-', $date)[1]),intval(explode('-', $date)[0]));
        $check_date = $request->input('check_date');
        $check_date = Carbon::createFromDate(intval(explode('-', $check_date)[2]),intval(explode('-', $check_date)[1]),intval(explode('-', $check_date)[0]));
        $description = $request->input('description');
        $bank = Bank::find(intval($request->input('bank')));
        $beneficiary = $request->input('beneficiary');
        $check_number = $request->input('checkact');

        for($i = 1; $i <= 10; $i++)
        {
            $accounts[] = intval($request->input('account'.$i)); // Id's de objeto Account
            $ruts[] = $request->input('rut'.$i); // Sólo estará lleno algún campo si no existe un Identification
            $nombres[] = intval($request->input('nombre'.$i)); // Id's de objeto Identification
            $string_nombres[] = $request->input('string_nombre'.$i);
            $detalles[] = $request->input('detalle'.$i);
            $doctype_ids[] = $request->input('doctype_id'.$i);
            $doc_numbers[] = $request->input('doc_number'.$i);
            $fechas[] = $request->input('fecha'.$i);
            $deberes[] = intval($request->input('debe'.$i));
            $haberes[] = intval($request->input('haber'.$i));
        }
        // End recuperar valores desde el request

        // Validar que al menos se llenaron dos lineas del voucher
        $count = 0;
        for($i = 0; $i < 10; $i++)
        {
            if(!$accounts[$i]) continue;
            $count++;
        }
        if($count < 2)
            return redirect()->back()->withErrors(['Debe llenar al menos dos líneas del voucher.']);
        // End validar que al menos se llenaron dos lineas del voucher

        if($auto_correl){
            $auxVoucher = Voucher::where('type', $tipo)->whereYear('date', '=', $date->year)->orderBy('id', 'desc')->first();
            if($auxVoucher){
                $val = $auxVoucher->sequence;
                $correl = $val + 1;
            }else{
                $correl = 1;
            }
        }
        else
            $correl = intval($request->input('correl'));

        // Verificación que el correlativo no exista, sino buscar hasta que encuentre uno libre
        while(true){
            if(Voucher::where('type', $tipo)->where('sequence', $correl)->count())
                $correl++;
            else
                break;
        }
        // End verificación que el correlativo no exista, sino buscar hasta que encuentre uno libre

        // Generar un objeto Voucher y guardarlo en la base de datos
        $voucher = new Voucher();
        $voucher->type = $tipo;
        $voucher->sequence = $correl;
        $voucher->date = $date;
        $voucher->description = $description;
        $voucher->bank_id = $bank->id;
        $voucher->beneficiary = $beneficiary;
        $voucher->check_number = $check_number;
        $voucher->check_date = $check_date;

        // Guardar imagen en servidor
        if($request->hasFile('img'))
        {
            $img = $request->file('img');

            $filename = time() . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(null, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save( public_path('/uploads/imgs/' . $filename ) );

            $voucher->img = $filename;
            // End guardar imagen en servidor
        }

        $voucher->save();
        // End generar un objeto Voucher y guardarlo en la base de datos

        // Actualizar Nº de cheque del banco
        $bank->checkact = $check_number;
        $bank->save();
        // End actualizar Nº de cheque del banco

        // Comenzar a validar líneas del voucher
        for($i = 0; $i < 10; $i++)
        {
            $identification = null;
            // Validar si la línea actual posee una cuenta contable, de lo contrario se saltará
            if(!$accounts[$i]) continue;
            $account = Account::find($accounts[$i]);
            if(!$account) continue;
            // End validar si la línea actual posee una cuenta contable, de lo contrario se saltará

            if($account->ctacte2 == 'S'){
                // Identificar el RUT / Nombre ingresados
                if($nombres[$i] && $nombres[$i] != 0){
                    $identification = Identification::find($nombres[$i]);
                }elseif ($ruts[$i] && $string_nombres[$i]) {
                    // Validación extra, en caso de RUT nuevo en multiples lineas
                    $identification = Identification::where('rut', $ruts[$i])->first();
                    if(!$identification)
                    {
                        // Generar nuevo Identification
                        $identification = new Identification();
                        $identification->rut = $ruts[$i];
                        $identification->name = $string_nombres[$i];
                        $identification->save();
                        // End generar nuevo Identification
                    }
                }
                // End identificar el RUT / Nombre ingresados 
            }
            // Generar Voucherdetail
            $voucherdetail = new Voucherdetail();
            $voucherdetail->voucher_id = $voucher->id;
            $voucherdetail->account_id = $account->id;
            if($account->ctacte2 == 'S')
                $voucherdetail->identification_id = $identification->id;
            $voucherdetail->detail = $detalles[$i];
            if($doctype_ids[$i])
                $voucherdetail->doctype_id = $doctype_ids[$i];
            if($doc_numbers[$i])
                $voucherdetail->doc_number = $doc_numbers[$i];
            $voucherdetail->date = Carbon::createFromDate(intval(explode('-', $fechas[$i])[2]),intval(explode('-', $fechas[$i])[1]),intval(explode('-', $fechas[$i])[0]));
            $voucherdetail->debit = $deberes[$i];
            $voucherdetail->credit = $haberes[$i];

            $voucherdetail->save();
            // End generar Voucherdetail
        }
        $this->addlog('Generó nuevo voucher de Egreso: ' . $voucher->sequence . '-' . $voucher->date->year);

        $request->session()->flash('success', 'El voucher ha sido generado exitosamente');
        return redirect('/view/voucher/' . $tipo . '/' . $voucher->sequence . '-' . $voucher->date->year);
    }

    public function newTransferGet()
    {
        $auxVoucher = Voucher::where('type', 'T')->whereYear('date', '=', Carbon::now()->year)->orderBy('id', 'desc')->first();
        if($auxVoucher)
            $correl = $auxVoucher->sequence + 1;
        else
            $correl = 1;
        $accounts = Account::where('nivel', 4)->orderBy('codigo', 'asc')->get();
        return view('new.voucher.transfer', ['accounts' => $accounts, 'correl' => $correl]);
    }

    public function newTransferPost(Request $request)
    {
        $accounts = [];
        $detalles = [];
        $doctype_ids = [];
        $doc_numbers = [];
        $fechas = [];
        $deberes = [];
        $haberes = [];

        // Recuperar valores desde el request
        $tipo = 'T';
        $auto_correl = $request->input('auto_correl');
        $date = $request->input('date');
        $date = Carbon::createFromDate(intval(explode('-', $date)[2]),intval(explode('-', $date)[1]),intval(explode('-', $date)[0]));
        $description = $request->input('description');

        for($i = 1; $i <= 10; $i++)
        {
            $accounts[] = intval($request->input('account'.$i)); // Id's de objeto Account
            $detalles[] = $request->input('detalle'.$i);
            $doctype_ids[] = $request->input('doctype_id'.$i);
            $doc_numbers[] = $request->input('doc_number'.$i);
            $fechas[] = $request->input('fecha'.$i);
            $deberes[] = intval($request->input('debe'.$i));
            $haberes[] = intval($request->input('haber'.$i));
        }
        // End recuperar valores desde el request

        // Validar que al menos se llenaron dos lineas del voucher
        $count = 0;
        for($i = 0; $i < 10; $i++)
        {
            if(!$accounts[$i]) continue;
            $count++;
        }
        if($count < 2)
            return redirect()->back()->withErrors(['Debe llenar al menos dos líneas del voucher.']);
        // End validar que al menos se llenaron dos lineas del voucher

        if($auto_correl){
            $auxVoucher = Voucher::where('type', $tipo)->whereYear('date', '=', $date->year)->orderBy('id', 'desc')->first();
            if($auxVoucher){
                $val = $auxVoucher->sequence;
                $correl = $val + 1;
            }else{
                $correl = 1;
            }
        }
        else
            $correl = intval($request->input('correl'));

        // Verificación que el correlativo no exista, sino buscar hasta que encuentre uno libre
        while(true){
            if(Voucher::where('type', $tipo)->where('sequence', $correl)->count())
                $correl++;
            else
                break;
        }
        // End verificación que el correlativo no exista, sino buscar hasta que encuentre uno libreno

        // Generar un objeto Voucher y guardarlo en la base de datos
        $voucher = new Voucher();
        $voucher->type = $tipo;
        $voucher->sequence = $correl;
        $voucher->date = $date;
        $voucher->description = $description;

        // Guardar imagen en servidor
        if($request->hasFile('img'))
        {
            $img = $request->file('img');

            $filename = time() . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(null, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save( public_path('/uploads/imgs/' . $filename ) );

            $voucher->img = $filename;
            // End guardar imagen en servidor
        }

        $voucher->save();
        // End generar un objeto Voucher y guardarlo en la base de datos

        // Comenzar a validar líneas del voucher
        for($i = 0; $i < 10; $i++)
        {
            // Validar si la línea actual posee una cuenta contable, de lo contrario se saltará
            if(!$accounts[$i]) continue;
            $account = Account::find($accounts[$i]);
            if(!$account) continue;
            // End validar si la línea actual posee una cuenta contable, de lo contrario se saltará
            // Generar Voucherdetail
            $voucherdetail = new Voucherdetail();
            $voucherdetail->voucher_id = $voucher->id;
            $voucherdetail->account_id = $account->id;
            $voucherdetail->detail = $detalles[$i];
            if($doctype_ids[$i])
                $voucherdetail->doctype_id = $doctype_ids[$i];
            if($doc_numbers[$i])
                $voucherdetail->doc_number = $doc_numbers[$i];
            $voucherdetail->date = Carbon::createFromDate(intval(explode('-', $fechas[$i])[2]),intval(explode('-', $fechas[$i])[1]),intval(explode('-', $fechas[$i])[0]));
            $voucherdetail->debit = $deberes[$i];
            $voucherdetail->credit = $haberes[$i];

            $voucherdetail->save();
            // End generar Voucherdetail
        }
        $this->addlog('Generó nuevo voucher de Traspaso: ' . $voucher->sequence . '-' . $voucher->date->year);

        $request->session()->flash('success', 'El voucher ha sido generado exitosamente');
        return redirect('/view/voucher/' . $tipo . '/' . $voucher->sequence . '-' . $voucher->date->year);
    }

    public function delete(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);
        $desc = ($voucher->type == 'I' ? 'Ingreso' : ($voucher->type == 'E' ? 'Egreso' : ($voucher->type == 'T' ? 'Traspaso' : 'Desconocido')));

        if($voucher->delete())
        {
            $this->addlog('Eliminó voucher de ' . $desc . ': ' . $voucher->sequence . '-' . $voucher->date->year);
            $request->session()->flash('success', 'El voucher ha sido eliminado exitosamente');
        }
        else
            $request->session()->flash('warning', 'El voucher no ha podido ser eliminado');
        return redirect('/home');
    }

    public function updateGet($id)
    {
        $voucher = Voucher::find($id);

        dd($voucher);
    }

    public function generateFolios(Request $request)
    {
        $start = $request->input('start');
        $finish = $request->input('finish');

        return view('voucher.folio', ['start' => $start, 'finish' => $finish]);
    }
}

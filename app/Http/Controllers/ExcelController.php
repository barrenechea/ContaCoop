<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Account;
use App\Bank;
use App\Identification;
use App\Voucher;
use App\Voucherdetail;

use Carbon\Carbon;
use Excel;

class ExcelController extends Controller
{
    public function getAccounts()
    {
    	$accounts = Account::orderBy('codigo', 'asc')->get();
        $dataArray = [];
        foreach ($accounts as $account) {
            $dataArray[] = [$account->clase, $account->nivel, $account->codigo, $account->nombre, $account->fecucode ? $account->fecucode->code : '', $account->fecucode ? $account->fecucode->name : '', $account->ctacte, $account->ctacte2, $account->ctacte3, $account->ctacte4];
        }
        Excel::create(('PLAN_CUENTAS-'.Carbon::today()->format('d-m-Y')), function($excel) use ($dataArray)
        {
            $excel->sheet('Plan de Cuentas', function($sheet) use ($dataArray) {

                $sheet->appendRow(['Clase', 'Nivel', 'Código', 'Nombre', 'Código FECU', 'Descripción FECU', 'C.C.', 'RUT', 'FLU.', 'PATR.']);
                foreach ($dataArray as $row)
                    $sheet->appendRow($row);

                $sheet->setAutoFilter();
                $sheet->setAutoSize(true);
            });
        })->download('xlsx');
    }

    public function getBanks()
    {
    	$banks = Bank::all();
        $dataArray = [];
        foreach ($banks as $bank) {
            $dataArray[] = [$bank->name, $bank->checking_account, $bank->account ? $bank->account->codigo : '', $bank->account ? $bank->account->nombre : '', $bank->checkact];
        }
        Excel::create(('CUENTAS_BANCARIAS-'.Carbon::today()->format('d-m-Y')), function($excel) use ($dataArray)
        {
            $excel->sheet('Cuentas Bancarias', function($sheet) use ($dataArray) {

                $sheet->appendRow(['Banco', 'Cuenta Corriente', 'Código Cuenta Contable', 'Descripción Cuenta Contable', 'Último cheque emitido']);
                foreach ($dataArray as $row)
                    $sheet->appendRow($row);

                $sheet->setAutoFilter();
                $sheet->setAutoSize(true);
            });
        })->download('xlsx');
    }

    public function getIdentifications()
    {
    	$identifications = Identification::orderBy('rut', 'asc')->get();
        $dataArray = [];
        foreach ($identifications as $identification) {
            $dataArray[] = [$identification->rut, $identification->name];
        }
        Excel::create(('RUTS-'.Carbon::today()->format('d-m-Y')), function($excel) use ($dataArray)
        {
            $excel->sheet('RUTs en Sistema', function($sheet) use ($dataArray) {

                $sheet->appendRow(['RUT', 'Nombre']);
                foreach ($dataArray as $row)
                    $sheet->appendRow($row);

                $sheet->setAutoFilter();
                $sheet->setAutoSize(true);
            });
        })->download('xlsx');
    }

    public function logBook(Request $request)
    {

        $start = Carbon::createFromDate(intval(explode('-', $request->input('start'))[2]),intval(explode('-', $request->input('start'))[1]),intval(explode('-', $request->input('start'))[0]));
        $finish = Carbon::createFromDate(intval(explode('-', $request->input('finish'))[2]),intval(explode('-', $request->input('finish'))[1]),intval(explode('-', $request->input('finish'))[0]));
        $type = $request->input('type');

        if($start->gt($finish))
            Session::flash('danger', 'La fecha inicial no puede ser mayor a la fecha final');
        else
        {
            if($type == 'I' || $type == 'ALL')
                $incomes = Voucherdetail::whereHas('voucher', function ($query) {
                        $query->where('type', 'I');
                    })->whereMonth('date', '>=', $start->month)->whereYear('date', '>=', $start->year)->whereDay('date', '>=', $start->day)->whereMonth('date', '<=', $finish->month)->whereYear('date', '<=', $finish->year)->whereDay('date', '<=', $finish->day)->get();
            if ($type == 'E' || $type == 'ALL')
                $outcomes = Voucherdetail::whereHas('voucher', function ($query) {
                        $query->where('type', 'E');
                    })->whereMonth('date', '>=', $start->month)->whereYear('date', '>=', $start->year)->whereDay('date', '>=', $start->day)->whereMonth('date', '<=', $finish->month)->whereYear('date', '<=', $finish->year)->whereDay('date', '<=', $finish->day)->get();
            if ($type == 'T' || $type == 'ALL')
                $transfers = Voucherdetail::whereHas('voucher', function ($query) {
                        $query->where('type', 'T');
                    })->whereMonth('date', '>=', $start->month)->whereYear('date', '>=', $start->year)->whereDay('date', '>=', $start->day)->whereMonth('date', '<=', $finish->month)->whereYear('date', '<=', $finish->year)->whereDay('date', '<=', $finish->day)->get();

            // Workaround para pasar los datos dentro de la función Excel
            if(!isset($incomes))
                $incomes = false;
            if(!isset($outcomes))
                $outcomes = false;
            if(!isset($transfers))
                $transfers = false;
            // End workaround para pasar los datos dentro de la función Excel

            // Generar Excel
            Excel::create('LIBRO_DIARIO_'.$start->format('d-m-Y').'_AL_'.$finish->format('d-m-Y'), function($excel) use ($incomes, $outcomes, $transfers) 
            {
                if($incomes)
                {
                    $excel->sheet('INGRESOS', function($sheet) use ($incomes)
                    {
                        $sheet->setColumnFormat(array(
                                'M' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                                'N' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                                ));
                        $sheet->appendRow(['VOUCHER', 'FECHA VOUCHER', 'GLOSA', 'LINEA', 'COD. CUENTA', 'NOMBRE CUENTA', 'TIPO DOC.', 'NUM. DOC.', 'FECHA DOC.', 'RUN', 'NOMBRE', 'DETALLE', 'DEBE', 'HABER']);

                        foreach ($incomes as $income)
                        {
                            $row = [
                                $income->voucher->sequence . '-' . $income->voucher->date->year,
                                $income->voucher->date->format('d-m-Y'),
                                $income->voucher->description,
                                '',
                                $income->account->codigo,
                                $income->account->nombre,
                                $income->doctype ? $income->doctype->code : '',
                                $income->doc_number,
                                $income->date->format('d-m-Y'),
                                $income->identification ? $income->identification->rut : '',
                                $income->identification ? $income->identification->name : '',
                                $income->detail,
                                $income->debit,
                                $income->credit
                            ];
                            $sheet->appendRow($row);
                        }

                        setlocale(LC_TIME, 'es_ES.utf8');

                        if($incomes->count() > 0)
                        {
                            $debe = 'M';
                            $debe .= $incomes->count() + 2;
                            $sumdebe = '=SUM(M2:M';
                            $sumdebe .= $incomes->count() + 1;
                            $sumdebe .= ')';
                            $haber = 'N';
                            $haber .= $incomes->count() + 2;
                            $sumhaber = '=SUM(N2:N';
                            $sumhaber .= $incomes->count() + 1;
                            $sumhaber .= ')';
                            $sheet->setCellValue($debe, $sumdebe);
                            $sheet->setCellValue($haber, $sumhaber);
                            $sheet->cells($debe.':'.$haber, function($cells) {
                                $cells->setFontWeight('bold');
                            });
                        }
                        $sheet->setAutoFilter();
                        $sheet->setAutoSize(true);
                    });
                }
                if($outcomes)
                {
                    $excel->sheet('EGRESOS', function($sheet) use ($outcomes) {
                        $sheet->setColumnFormat(array(
                                'R' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                                'S' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                                ));
                        $sheet->appendRow(['VOUCHER', 'FECHA VOUCHER', 'BANCO', 'CUENTA', 'CHEQUE', 'FECHA CHEQUE', 'BENEFICIARIO', 'GLOSA', 'LINEA', 'COD. CUENTA', 'NOMBRE CUENTA', 'TIPO DOC.', 'NUM. DOC.', 'FECHA DOC.', 'RUN', 'NOMBRE', 'DETALLE', 'DEBE', 'HABER']);

                        foreach ($outcomes as $outcome)
                        {
                            $row = [
                                $outcome->voucher->sequence . '-' . $outcome->voucher->date->year,
                                $outcome->voucher->date->format('d-m-Y'),
                                $outcome->bank ? $outcome->bank->name : '',
                                $outcome->bank ? $outcome->bank->checking_account : '',
                                $outcome->voucher->check_number,
                                $outcome->voucher->check_date ? $outcome->voucher->check_date->format('d-m-Y') : '',
                                $outcome->voucher->beneficiary,
                                $outcome->voucher->description,
                                '',
                                $outcome->account->codigo,
                                $outcome->account->nombre,
                                $outcome->doctype ? $income->doctype->code : '',
                                $outcome->doc_number,
                                $outcome->date->format('d-m-Y'),
                                $outcome->identification ? $outcome->identification->rut : '',
                                $outcome->identification ? $outcome->identification->name : '',
                                $outcome->detail,
                                $outcome->debit,
                                $outcome->credit
                            ];
                            $sheet->appendRow($row);
                        }

                        setlocale(LC_TIME, 'es_ES.utf8');

                        if($outcomes->count() > 0)
                        {
                            $debe = 'R';
                            $debe .= $outcomes->count()+2;
                            $sumdebe = '=SUM(R2:R';
                            $sumdebe .= $outcomes->count()+1;
                            $sumdebe .= ')';
                            $haber = 'S';
                            $haber .= $outcomes->count()+2;
                            $sumhaber = '=SUM(S2:S';
                            $sumhaber .= $outcomes->count()+1;
                            $sumhaber .= ')';
                            $sheet->setCellValue($debe, $sumdebe);
                            $sheet->setCellValue($haber, $sumhaber);
                            $sheet->cells($debe.':'.$haber, function($cells) {
                                $cells->setFontWeight('bold');
                            });
                        }
                        $sheet->setAutoFilter();
                        $sheet->setAutoSize(true);
                    });
                }
                if($transfers)
                {
                    $excel->sheet('TRASPASOS', function($sheet) use ($transfers) {
                        $sheet->setColumnFormat(array(
                                'K' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                                'L' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                                ));
                        $sheet->appendRow(['VOUCHER', 'FECHA VOUCHER', 'GLOSA', 'LINEA', 'COD. CUENTA', 'NOMBRE CUENTA', 'TIPO DOC.', 'NUM. DOC.', 'FECHA DOC.', 'DETALLE', 'DEBE', 'HABER']);

                        foreach ($transfers as $transfer)
                        {
                            $row = [
                                $transfer->voucher->sequence . '-' . $transfer->voucher->date->year,
                                $transfer->voucher->date->format('d-m-Y'),
                                $transfer->voucher->description,
                                '',
                                $transfer->account->codigo,
                                $transfer->account->nombre,
                                $transfer->doctype ? $income->doctype->code : '',
                                $transfer->doc_number,
                                $transfer->date->format('d-m-Y'),
                                $transfer->detail,
                                $transfer->debit,
                                $transfer->credit
                            ];
                            $sheet->appendRow($row);
                        }

                        setlocale(LC_TIME, 'es_ES.utf8');

                        if($transfers->count() > 0)
                        {
                            $debe = 'K';
                            $debe .= $outcomes->count()+2;
                            $sumdebe = '=SUM(K2:K';
                            $sumdebe .= $outcomes->count()+1;
                            $sumdebe .= ')';
                            $haber = 'L';
                            $haber .= $outcomes->count()+2;
                            $sumhaber = '=SUM(L2:L';
                            $sumhaber .= $outcomes->count()+1;
                            $sumhaber .= ')';
                            $sheet->setCellValue($debe, $sumdebe);
                            $sheet->setCellValue($haber, $sumhaber);
                            $sheet->cells($debe.':'.$haber, function($cells) {
                                $cells->setFontWeight('bold');
                            });
                        }
                        $sheet->setAutoFilter();
                        $sheet->setAutoSize(true);
                    });
                }
            })->download('xlsx');
        }
        return redirect()->back();
    }

    public function generalLedger(Request $request)
    {
        Session::flash('danger', 'Se requiere información de productivo para poder generar la funcionalidad de libro mayor');
        return redirect()->back();
    }
}

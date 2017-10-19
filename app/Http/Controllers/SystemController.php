<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Config;
use App\Log;

class SystemController extends Controller
{
    public function index()
    {
        $config = Config::all();
    	return view('update.sysconfig', ['config' => $config]);
    }

    public function updateSysConfig(Request $request)
    {
        // Set all values to an easy and recognizable var
        $company_name = $request->input('company_name');
        $company_rut = $request->input('company_rut');
        $company_business_field = $request->input('company_business_field');
        $company_address = $request->input('company_address');
        $company_legal_representative_name = $request->input('company_legal_representative_name');
        $company_legal_representative_rut = $request->input('company_legal_representative_rut');

        // Set all config variables to the updated values
        $config = Config::where('name', 'company_name')->first();
        $config->value = $company_name;
        $config->save();

        $config = Config::where('name', 'company_rut')->first();
        $config->value = $company_rut;
        $config->save();

        $config = Config::where('name', 'company_business_field')->first();
        $config->value = $company_business_field;
        $config->save();

        $config = Config::where('name', 'company_address')->first();
        $config->value = $company_address;
        $config->save();

        $config = Config::where('name', 'company_legal_representative_name')->first();
        $config->value = $company_legal_representative_name;
        $config->save();

        $config = Config::where('name', 'company_legal_representative_rut')->first();
        $config->value = $company_legal_representative_rut;
        $config->save();

        $this->addlog('Actualizó información de la empresa');

        // Return
        $request->session()->flash('success', 'La información ha sido actualizada exitosamente');
        return redirect()->back();
    }

    public function getLogs(Request $request)
    {
        if($request->input('find'))
        {
            $searchTerm = $request->input('find');
            // Search by username
            $logs = Log::whereHas('user', function ($query) use ($searchTerm) {
                $query->where('username', 'LIKE', '%' . $searchTerm . '%');
            })->orderBy('created_at', 'desc')->get();

            if($logs->count() == 0)
            {
                // Search by name
                $logs = Log::whereHas('user', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', '%' . $searchTerm . '%');
                })->orderBy('created_at', 'desc')->get();
                if($logs->count() == 0)
                {
                    // Search by message
                    $logs = Log::where('message', 'LIKE', '%' . $searchTerm . '%')->orderBy('created_at', 'desc')->get();
                }
            }
        }
        else
            $logs = Log::orderBy('created_at', 'desc')->paginate(20);
    
        return view('list.logs', ['logs' => $logs, 'find' => $request->input('find')]);
    }
}

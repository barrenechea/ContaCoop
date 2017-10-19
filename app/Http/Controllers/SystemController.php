<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;

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

        // Return
        $request->session()->flash('success', 'La información ha sido actualizada exitosamente');
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Identification;
use App\FECUCode;
use App\Bank;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class DebugController extends Controller
{
    public function retrieveAccounts()
    {
    	$client = new Client();
		$res = $client->request('GET', 'http://panel.alamedamaipu.cl/api/maecue', [
		    'headers' => [
		        'Authorization' => env('API_KEY', '-')
		    ]
		]);

		foreach (json_decode($res->getBody()) as $value) {
			$account = new Account();
			$account->codigo = $value->codigo;

			$fecu = FECUCode::where('code', $value->codigofecu)->first();
			if($fecu)
				$account->fecucode_id = $fecu->id;

			$account->clase = $value->clase;
			$account->nivel = $value->nivel;
			$account->subcta = $value->subcta;
			$account->ctacte = $value->ctacte;
			$account->ctacte2 = $value->ctacte2;
			$account->ctacte3 = $value->ctacte3;
			$account->ctacte4 = $value->ctacte4;
			$account->estado = $value->estado;
			$account->estado2 = $value->estado2;
			$account->nombre = $value->nombre;

			$account->save();
		}

		return "Accounts: Done!";
    }

    public function retrieveIdentifications()
    {
    	$client = new Client();
		$res = $client->request('GET', 'http://panel.alamedamaipu.cl/api/tabaux10', [
		    'headers' => [
		        'Authorization' => env('API_KEY', '-')
		    ]
		]);
		
		foreach (json_decode($res->getBody()) as $value) {
			$identification = new Identification();
			$identification->rut = $value->kod;
			$identification->name = $value->desc;

			$identification->save();
		}

		return "Identifications: Done!";
    }

    public function retrieveBanks()
    {
    	$client = new Client();
		$res = $client->request('GET', 'http://panel.alamedamaipu.cl/api/tabanco', [
		    'headers' => [
		        'Authorization' => env('API_KEY', '-')
		    ]
		]);
		
		foreach (json_decode($res->getBody()) as $value) {
			if($value->codbanco == 0) continue;

			$bank = new Bank();
			$bank->name = $value->nombanco;
			$bank->checking_account = $value->ctacc;

			$account = Account::where('codigo', $value->ctacontab)->first();
			if($account)
				$bank->account_id = $account->id;

			$bank->checkact = $value->chequeact;

			$bank->save();
		}

		return "Banks: Done!";
    }
}

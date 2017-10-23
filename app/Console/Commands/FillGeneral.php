<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Doctype;
use App\Role;
use App\Config;

class FillGeneral extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:general';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill general data on database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(Role::count() == 0)
        {
            $var = new Role;
            $var->name = 'super_admin';
            $var->description = 'Laravel Super Administrator';
            $var->save();

            $var = new Role;
            $var->name = 'view_list_billdetail_payment';
            $var->description = 'Ver vouchers';
            $var->save();

            $var = new Role;
            $var->name = 'add_payment';
            $var->description = 'Agregar vouchers';
            $var->save();

            $var = new Role;
            $var->name = 'modify_payment';
            $var->description = 'Modificar vouchers';
            $var->save();

            $var = new Role;
            $var->name = 'delete_payment';
            $var->description = 'Eliminar vouchers';
            $var->save();

            $var = new Role;
            $var->name = 'view_report_external_accounting';
            $var->description = 'Ver reportería';
            $var->save();

            $var = new Role;
            $var->name = 'view_log';
            $var->description = 'Ver registro de actividad (para auditorías)';
            $var->save();

            $var = new Role;
            $var->name = 'modify_admin_account';
            $var->description = 'Administrar ContaCoop';
            $var->save();
            echo "Roles: Done!\n";
        }
        else
            echo "Roles data already on database\n";

        if(Config::count() == 0)
        {
            $var = new Config;
            $var->name = 'company_name';
            $var->value = 'Cooperativa de Servicios Centro Comercial Alameda Maipú Limitada';
            $var->save();

            $var = new Config;
            $var->name = 'company_rut';
            $var->value = '73.923.900-1';
            $var->save();

            $var = new Config;
            $var->name = 'company_business_field';
            $var->value = 'Consejo de Administración de Edificios y Condominios';
            $var->save();

            $var = new Config;
            $var->name = 'company_address';
            $var->value = "Avda. Lib. Bernardo O'Higgins 3001, Santiago";
            $var->save();

            $var = new Config;
            $var->name = 'company_legal_representative_name';
            $var->value = 'Ricardo Orellana Labra';
            $var->save();

            $var = new Config;
            $var->name = 'company_legal_representative_rut';
            $var->value = '7.699.435-8';
            $var->save();
            echo "Config: Done!\n";
        }
        else
            echo "Config data already on database\n";
        
        if(Doctype::count() == 0)
        {
            $var = new Doctype;
            $var->code = 'B';
            $var->description = 'BOLETA';
            $var->save();

            $var = new Doctype;
            $var->code = 'CH';
            $var->description = 'CHEQUE';
            $var->save();

            $var = new Doctype;
            $var->code = 'F A';
            $var->description = 'FACTURA ESTÁNDAR AFECTA';
            $var->save();

            $var = new Doctype;
            $var->code = 'F E';
            $var->description = 'FACTURA ESTÁNDAR EXENTA';
            $var->save();

            $var = new Doctype;
            $var->code = 'FE';
            $var->description = 'FACTURA ELECTRÓNICA';
            $var->save();

            $var = new Doctype;
            $var->code = 'FEA';
            $var->description = 'FACTURA ELECTRÓNICA AFECTA';
            $var->save();

            $var = new Doctype;
            $var->code = 'FEE';
            $var->description = 'FACTURA ELECTRÓNICA EXENTA';
            $var->save();

            $var = new Doctype;
            $var->code = 'OT';
            $var->description = 'OTROS';
            $var->save();

            echo "Doctype: Done!\n";
        }
        else
            echo "Doctype data already on database\n";
    }
}

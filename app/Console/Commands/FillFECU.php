<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\FECUCode;

class FillFECU extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:fecu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill FECUCodes on database';

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
        if(FECUCode::count() == 0)
        {
            $var = new FECUCode;
            $var->code = '5.11.10.10';
            $var->name = 'Efectivo y efectivo equivalente';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.10.20';
            $var->name = 'Activos financieros a valor razonable con cambios en resultados';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.10.30';
            $var->name = 'Activos financieros disponibles para la venta';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.10.40';
            $var->name = 'Otros activos financieros';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.10.50';
            $var->name = 'Deudores por ventas y otras cuentas por cobrar';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.10.60';
            $var->name = 'Cuentas por cobrar a entidades relacionadas';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.10.70';
            $var->name = 'Existencias';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.10.80';
            $var->name = 'Activos biológicos';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.10.90';
            $var->name = 'Impuestos por recuperar';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.11.10';
            $var->name = 'Anticipo de dividendos';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.11.20';
            $var->name = 'Otros activos corrientes';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.10.00';
            $var->name = 'Subtotal activos corrientes';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.20.10';
            $var->name = 'Activos no corrientes clasificados como mantenidos para la venta';
            $var->save();

            $var = new FECUCode;
            $var->code = '5.11.00.00';
            $var->name = 'TOTAL ACTIVOS CORRIENTES';
            $var->save();

            // -------------------------------------

            echo "Done!\n";
        }
        else
            echo "Data already on database\n";
    }
}

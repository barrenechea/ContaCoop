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
            $var->code = '5.10.00.00';
            $var->name = 'TOTAL  A C T I V O S';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.00.00';
            $var->name = 'TOTAL ACTIVOS CORRIENTES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.10.10';
            $var->name = 'EFECTIVO Y EFECTIVOS EQUIVALENTE';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.10.20';
            $var->name = 'ACTIVOS FINANCIEROS A VALOR RAZONABLE';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.10.30';
            $var->name = 'ACTIVOS FINANCIEROS DISPONIBLES PARA VENTA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.10.40';
            $var->name = 'OTROS ACTIVOS FINANCIEROS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.10.50';
            $var->name = 'DEUDORES POR VENTAS Y CTS.X COBRAR';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.10.60';
            $var->name = 'CUENTAS POR COBRAR ENT.RELACIONADAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.10.70';
            $var->name = 'EXISTENCIAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.10.80';
            $var->name = 'ACTIVOS BIOLOGICOS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.10.90';
            $var->name = 'IMPUESTOS POR RECUPERAR';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.11.10';
            $var->name = 'ANTICIPOS DE DIVIDENDOS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.11.20';
            $var->name = 'OTROS ACTIVOS CORRIENTES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.11.20.10';
            $var->name = 'ACTIVOS NO CTE.MANTENIDOS PARA LA VENTA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.00.00';
            $var->name = 'TOTAL ACTIVOS NO CORRIENTES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.10.10';
            $var->name = 'INSTRUMENTOS FINANCIEROS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.10.20';
            $var->name = 'ACT.FINANCIEROS DISPONIBLES PARA LA VENTA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.10.30';
            $var->name = 'DEUDORES POR VTAS.Y OTRAS CTAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.10.40';
            $var->name = 'CTAS.POR COB.EMP.RELACIONADAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.10.50';
            $var->name = 'INVERSIONES EN OTRAS EMPRESAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.10.60';
            $var->name = 'PLUSVALIA COMPRADA (GOODDWILL)';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.10.70';
            $var->name = 'ACTIVOS INTANGIBLES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.10.80';
            $var->name = 'PROPIEDADES, PLANTAS Y EQUIPOS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.10.90';
            $var->name = 'ACTIVOS BIOLOGICOS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.11.10';
            $var->name = 'PROPIEDADES DE INVERSION';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.11.20';
            $var->name = 'ACTIVOS POR IMPUESTOS DIFERIDO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.12.11.30';
            $var->name = 'OTROS ACTIVOS NO CORRIENTES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.20.00.00';
            $var->name = 'TOTAL P A S I V O S  Y PATRIMONIO NETO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.00.00';
            $var->name = 'TOTAL PASIVOS CORRIENTES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.00';
            $var->name = 'SUBTOTAL PASIVOS CORRIENTES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.10';
            $var->name = 'OBLIGACIONES CON INST.DE CREDITO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.20';
            $var->name = 'OBLIGACIONES POR TITULOS DE DEUDA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.30';
            $var->name = 'ACREEDORES COMERCIALES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.40';
            $var->name = 'OTROS ACREEDORES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.50';
            $var->name = 'CTAS.POR PAGAR EMP.RELACIONADAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.60';
            $var->name = 'DIVIDENDOS POR PAGAR';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.70';
            $var->name = 'PROVISIONES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.80';
            $var->name = 'IMPUESTOS A LA RENTA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.10.90';
            $var->name = 'OTROS PASIVOS CORRIENTES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.21.20.10';
            $var->name = 'PASIVOS DIREC.ASOC.C/ACTIVOS NO CORRTES.CLASIF. COMO P/VENTA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.22.00.00';
            $var->name = 'TOTAL PASIVOS NO CORRIENTES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.22.10.10';
            $var->name = 'OBLIGACIONES CON INST.DE CREDITO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.22.10.20';
            $var->name = 'OBLIGACIONES POR TITULOS DE DEUDA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.22.10.30';
            $var->name = 'OTROS PASIVOS FINANCIEROS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.22.10.40';
            $var->name = 'CUENTAS POR PAGAR EMP.RELACIONADAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.22.10.50';
            $var->name = 'PROVISIONES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.22.10.60';
            $var->name = 'PASIVOS POR IMP.DIFERIDOS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.22.10.70';
            $var->name = 'OTROS PASIVOS NO CORRIENTES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.24.00.00';
            $var->name = 'TOTAL PATRIMONIO ATRIBUIBLE A LOS ACCIONISTAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.24.10.10';
            $var->name = 'CAPITAL PAGADO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.24.10.20';
            $var->name = 'SOBREPRECIO EN VTA.ACCIONES PROPIAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.24.10.30';
            $var->name = 'ACCIONES PROPIAS EN CARTERA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.24.10.40';
            $var->name = 'RESERVA POR AJUSTES DE VALOR';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.24.10.50';
            $var->name = 'OTRAS RESERVAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.24.10.60';
            $var->name = 'RESULTADOS ACUMULADOS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.24.20.00';
            $var->name = 'UTILIDAD (PERDIDA) DEL EJERCICIO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.24.30.00';
            $var->name = 'DIVIDENDOS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.25.00.00';
            $var->name = 'INTERES MINORITARIO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.26.00.00';
            $var->name = 'TOTAL PATRIMONIO NETO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.30.00.00';
            $var->name = 'RESULTADOS INTEGRALES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.00.00';
            $var->name = 'UTILIDAD (PERDIDA) DEL EJERCICIO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.10.00';
            $var->name = 'MARGEN BRUTO';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.10.10';
            $var->name = 'INGRESOS DE LA OPERACION';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.10.20';
            $var->name = 'COSTOS DE VENTAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.11.10';
            $var->name = 'GASTOS DE ADMINISTRACION';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.11.20';
            $var->name = 'GASTOS DE COMERCIALIZACION';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.11.30';
            $var->name = 'OTROS INGRESOS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.00';
            $var->name = 'RESULTADO ANTES IMPUESTO A LA RENTA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.10';
            $var->name = 'INGRESOS FINANCIEROS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.20';
            $var->name = 'OTROS INGRESOS FINANCIEROS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.30';
            $var->name = 'GASTOS FINANCIEROS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.40';
            $var->name = 'OTROS GASTOS FINANCIEROS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.50';
            $var->name = 'RESULTADOS INV.EN OTRAS SOCIEDADES';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.60';
            $var->name = 'DIFERENCIA DE CAMBIOS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.70';
            $var->name = 'ACTUALIZACION DE VALOR';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.80';
            $var->name = 'OTRAS GANANCIAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.12.90';
            $var->name = 'OTRAS PERDIDAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.13.00';
            $var->name = 'UTILIDAD (PERDIDA) DE ACT.CONTINUADAS';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.13.10';
            $var->name = 'IMPUESTOS A LA RENTA';
            $var->save();
            
            $var = new FECUCode;
            $var->code = '5.31.14.10';
            $var->name = 'RESULT.DEL PER.PROCEDENTE DE ACT.DISCONTINUADAS';
            $var->save();
            
            // -------------------------------------

            echo "FECU: Done!\n";
        }
        else
            echo "FECU Data already on database\n";
    }
}

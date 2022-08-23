<?php 

namespace Josefranciscocruzcorro\Utiles;

class Utiles
{
    public static function validarCedula($cedula)
    {
        $digitos = explode('',$cedula);

        if (count($digitos) != 10 || $digitos[0] > 3) {
            return false;
        }

        $suma = 0;

        for ($i=0; $i < 9; $i++) { 
            $operacion = $digitos[$i] * ($i%2==0?2:1);
            if($operacion>=10) $operacion-=9;  
            $suma += $operacion;
        }

        $comparar = 10 - ($suma%10);
        if($comparar == 10) $comparar=0;

        return $comparar == $digitos[9];
    }

    public static function validarRuc($ruc)
    {
        # code...
        $digitos = explode('',$ruc);

        if (count($digitos) != 13 || $digitos[0] > 3) {
            return false;
        }

        $cedula = substr($ruc,0,10);

        return self::validarCedula($cedula);
    }

    public static function claveAcceso($fecha,$tipoComprobante,$ruc,$ambiente,$estab,$pro_emi,$secuencial,$tipoEmision=1)
    {
        # code...
        $f = explode("-",$fecha);

        $codigoNumerico = substr("".time(),0,8);

        $s = $secuencial;

        if (strlen($ruc) != 13) {
            # code...
            if (strlen($ruc)==10) {
                # code...
                $ruc .= '001';
            }else{
                $ruc = "9999999999999";
            }
        }

        return $f[2].$f[1].$f[0].$tipoComprobante.$ruc.$ambiente.$estab.$pro_emi.$s.$codigoNumerico.$tipoEmision.self::modulo11($f[2].$f[1].$f[0].$tipoComprobante.$ruc.$ambiente.$estab.$pro_emi.$s.$codigoNumerico.$tipoEmision);
    }

    public static function modulo11($numero)
    {
        # code...
        $x = str_split($numero."");

        $r = 0;
        $dig = 2;
        for ($i=count($x)-1; $i >= 0; $i--) { 
            # code...
            if ($dig == 8) {
                # code...
                $dig = 2;
            }
            $l = $x[$i];


            $rs = $dig * $l;

            $r+= $rs;

            $dig++;
        }

        $rd = $r % 11;
        $rt = 11 - $rd;

        if ($rt == 11) {
            # code...
            return 0;
        }
        if ($rt == 10) {
            # code...
            return 1;
        }

        return $rt;
    }
}

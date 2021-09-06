<?php

use Illuminate\Support\Facades\DB;
use App\Models\Store;
use Illuminate\Support\Facades\Date;

//Obtener presupuestos
if(!function_exists('fnGetBudget'))
{
    function fnGetBudget($store)
    {
        return Store::where('id', $store)->value('budget');
    }
}

//Obtener presupuestos
if(!function_exists('fnGetBudgetFull'))
{
    function fnGetBudgetFull($store)
    {
        return "PRESUPUESTO_" . fnGetBudget($store);
    }
}

//Obtener giftcards
if(!function_exists('fnGetGiftcard'))
{
    function fnGetGiftcard($store)
    {
        return Store::where('id', $store)->value('giftcard');
    }
}

//Obtener giftcards
if(!function_exists('fnGetGiftcardFull'))
{
    function fnGetGiftcardFull($store)
    {
        return "GIFTCARD_" . fnGetGiftcard($store);
    }
}

//Generar identificador para los reportes
if(!function_exists('fnGenerateReportId'))
{
    function fnGenerateReportId($filters)
    {
        return md5(implode('.', $filters));
    }
}

//Generar la cantidad de minutos que un reporte estara en la cache
if(!function_exists('fnRememberReportTime'))
{
    function fnRememberReportTime($fecha)
    {
        if(date('Y-m-d') > date('Y-m-d', strtotime($fecha)))
        {
            return  Date::now()->addMinutes(10);
        }

        return Date::now()->addWeek();
    }
}

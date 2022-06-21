<?php

use App\Models\Store;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

//Obtener los establecimientos asignados a cada usuario, solo nombre e id
if(!function_exists('fnGetMyStores'))
{
    function fnGetMyStores()
    {
        $stores = Cache::remember('stores-' . auth()->user()->id, now()->addHours(8), function(){
            if(auth()->user()->isSuperAdmin())
                return Store::orderBy('name')->pluck('name', 'id')->toArray();

            return auth()->user()->stores->pluck('name', 'id')->sort()->toArray();
        });

        return $stores;
    }
}

//Obtener presupuestos
if(!function_exists('fnGetBudget'))
{
    function fnGetBudget($store)
    {
        return Store::where('id', $store)->value('budget');
    }
}

//Obtener presupuestos con PRESUPUESTO_
if(!function_exists('fnGetBudgetFull'))
{
    function fnGetBudgetFull($store)
    {
        return "PRESUPUESTO_" . fnGetBudget($store);
    }
}

//Obtener giftcard
if(!function_exists('fnGetGiftcard'))
{
    function fnGetGiftcard($store)
    {
        return Store::where('id', $store)->value('giftcard');
    }
}

//Obtener giftcard con GIFTCARD_
if(!function_exists('fnGetGiftcardFull'))
{
    function fnGetGiftcardFull($store)
    {
        return "GIFTCARD_" . fnGetGiftcard($store);
    }
}

//Obtener todas las giftcards del usuario
if(!function_exists('fnGetAllGiftcards'))
{
    function fnGetAllGiftcards()
    {
        $myStores = array_keys(fnGetMyStores());
        return Store::whereIn('id', $myStores)->pluck('giftcard')->toArray();
    }
}

//Obtener todas los presupuestos del usuario
if(!function_exists('fnGetAllBudgets'))
{
    function fnGetAllBudgets()
    {
        $myStores = array_keys(fnGetMyStores());
        return Store::whereIn('id', $myStores)->pluck('budget')->toArray();
    }
}

//Obtener todas las giftcards del usuario con GIFTCARD_
if(!function_exists('fnGetAllGiftcardsFull'))
{
    function fnGetAllGiftcardsFull()
    {
        $myStores = array_keys(fnGetMyStores());
        $giftcards =  Store::whereIn('id', $myStores)->pluck('giftcard')->toArray();
        array_walk($giftcards, function(&$giftcard, $key){
            $giftcard = 'GIFTCARD_' . $giftcard;
        });

        return $giftcards;
    }
}

//Obtener todas los persupuestos del usuario con PRESUPUESTO_
if(!function_exists('fnGetAllBudgetsFull'))
{
    function fnGetAllBudgetsFull()
    {
        $myStores = array_keys(fnGetMyStores());
        $budgets =  Store::whereIn('id', $myStores)->pluck('budget')->toArray();
        array_walk($budgets, function(&$budget, $key){
            $budget = 'PRESUPUESTO_' . $budget;
        });

        return $budgets;
    }
}

//Obtener el nodo tokencash del establecimiento
if(!function_exists('fnGetTokencashNode'))
{
    function fnGetTokencashNode($store)
    {
        return Store::where('id', $store)->value('node');
    }
}

//Obtener el nombre de un establecimiento
if(!function_exists('fnGetStoreName'))
{
    function fnGetStoreName($store)
    {
        return Store::find($store)->name;
    }
}

//Obtener la informacion de los establecimientos que tiene asignado el usuario
if(!function_exists('fnGetMyStoresNodes'))
{
    function fnGetMyStoresNodes()
    {
        $myStores = array_keys(fnGetMyStores());
        return Store::whereIn('id', $myStores)->pluck('node')->toArray();
    }
}

//Obtener id de merchant asociado a un establecimiento
if(!function_exists('fnGetStoreMerchant'))
{
    function fnGetStoreMerchant($store)
    {
        return Store::where('id', $store)->value('merchant_id');
    }
}

//Obtener todos los merchants de mis establecimientos
if(!function_exists('fnGetMyStoresMerchants'))
{
    function fnGetMyStoresMerchants()
    {
        $myStores = array_keys(fnGetMyStores());
        return Store::whereIn('id', $myStores)->pluck('merchant_id')->toArray();
    }
}

//Obtener los vendedores de cada establecimiento
if(!function_exists('fnGetSellers'))
{
    function fnGetSellers($store)
    {
        $store = Store::find($store);
        return $store->sellers()->pluck('name');
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
            return Date::now()->addWeek();
        }

        return  Date::now()->addMinutes(10);

    }
}

if(!function_exists('fnGetPeriodDays'))
{
    function fnGetPeriodDays($initialDate, $endDate)
    {
        $range = [];
        $start = new DateTime($initialDate);
        $end   = new DateTime($endDate);
        $end->modify('+1 day');
        $rangePeriod = new DatePeriod($start, new DateInterval('P1D'), $end);
        foreach($rangePeriod as $date)
        {
            $key = $date->format("d/m/Y");
            array_push($range, $key);
        }

        return $range;
    }
}

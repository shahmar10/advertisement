<?php

namespace App\Exports;

use App\Models\Advertisement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdvertisementExport implements FromView
{
    public function view(): View
    {
        $advertisements = Advertisement::query()
            ->from("advertisements as a")
            ->select(
                'a.id',
                'a.body',
                'su.name as creator',
                'c.name as car',
                'cm.name as model',
                'a.price',
                'cr.name as currency',
                'a.created_at',
                'a.updated_at',
                'ft.name as fuel_type',
                'g.name as gear',
                'ai.year',
                'cl.name as color',
                'ai.distance',
                'ai.vin_code',
                'ct.name as city',
            )
            ->join("site_users as su", 'su.id', 'a.created_by')
            ->join("cars as c", 'c.id', 'a.car_id')
            ->join("car_models as cm", 'cm.id', 'a.model_id')
            ->join("currencies as cr", 'cr.id', 'a.currency_id')
            ->join("advertisement_infos as ai", 'ai.advertisement_id', 'a.id')
            ->join("fuel_types as ft", 'ft.id', 'ai.fuel_type_id')
            ->join("gears as g", 'g.id', 'ai.gear_id')
            ->join("bans as b", 'b.id', 'ai.ban_id')
            ->join("colors as cl", 'cl.id', 'ai.color_id')
            ->join("cities as ct", 'ct.id', 'ai.city_id')
            ->with(['suppliers'])
            ->get();

        return view('dashboard.export.advertisement', compact('advertisements'));
    }
}

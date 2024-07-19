<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Car;
use App\SelectData\AdvertisementSelect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $cars = AdvertisementSelect::car();
        $fuels = AdvertisementSelect::fuel();

        $afterMonth = date('Y-m-d', time() + 3600 * 24 * 30);

        $advertisements = Advertisement::query()
            ->from("advertisements as a")
            ->select(
                'a.id',
                DB::raw("CONCAT(a.price,  ' ', cr.name) as price"),
                DB::raw("CONCAT(c.name,  ' ', cm.name) as car"),
                'ai.year',
                'ai.distance',
                'a.updated_at',
                'ct.name as city',
            )
            ->join('currencies as cr', 'cr.id', 'a.currency_id')
            ->join('cars as c', 'c.id', 'a.car_id')
            ->join('car_models as cm', 'cm.id', 'a.model_id')
            ->join('advertisement_infos as ai', 'ai.advertisement_id', 'a.id')
            ->join('cities as ct', 'ct.id', 'ai.city_id')
            ->where('a.status', 2)
//            ->where(DB::raw('ADDDATE(a.updated_at, 30)'), '>', Carbon::now()->format('Y-m-d'))
            ->where('expired_at', '>=', Carbon::now()->format('Y-m-d'))
            ->with(['photo' => function ($q) {
                $q->select('advertisement_id', 'photo');
            }]);

        $advertisements = $this->filter($advertisements, $request);

        $advertisements = $advertisements
            ->orderByDesc('a.updated_at')
            ->paginate(20);

        return view('site.home', compact('advertisements', 'cars'));
    }

    private function filter($advertisements, $request)
    {
        if ($request->car_id != null)
        {
            $advertisements = $advertisements->where('a.car_id', $request->car_id);
        }

        return $advertisements;
    }

    public function show($id)
    {
        $advertisement = Advertisement::query()
            ->from("advertisements as a")
            ->select(
                'a.id',
                'a.body',
                'su.name as creator',
                'su.phone as creator_phone',
                'c.name as car',
                'cm.name as model',
                'a.price',
                'cr.name as currency',
                'a.created_at',
                'ft.name as fuel_type',
                'g.name as gear',
                'ai.year',
                'cl.name as color',
                'ai.distance',
                'ai.vin_code',
                'ct.name as city',
                'b.name as ban'
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
            ->where('a.id', $id)
            ->where('expired_at', '>=', Carbon::now()->format('Y-m-d'))
            ->with(['photos', 'suppliers'])
            ->firstOrFail();

        return view('site.detail', compact('advertisement'));
    }
}

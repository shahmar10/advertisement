<?php

namespace App\Http\Controllers\Site\Car;

use App\Http\Controllers\Controller;
use App\Http\Utils\MessageUtil;
use App\Models\CarModel;
use App\Models\SiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CarController extends Controller
{
    public function getCarModelByCarId($car_id)
    {
        $models = CarModel::query()
            ->select(
                'id',
                'name'
            )
            ->where('car_id', $car_id)
            ->get();

        return response($models);
    }
}

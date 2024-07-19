<?php

namespace App\Http\Controllers\Dashboard\CarModel;

use App\Http\Controllers\Controller;
use App\Http\Utils\MessageUtil;
use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function create()
    {
        $cars = $this->getCarForSelect();

        return view("dashboard.car-model.create", compact('cars'));
    }

    public function index(Request $request)
    {
        $models = CarModel::query()
            ->from('car_models as cm')
            ->select(
                'cm.id',
                'cm.name',
                'c.name as car',
                'cm.created_at',
                'u.name as creator'
            )
            ->join('cars as c', 'c.id', 'cm.car_id')
            ->join('users as u', 'cm.created_by', 'u.id')
            ->paginate(10);

        return view('dashboard.car-model.index', compact('models'));
    }

    public function trash(Request $request)
    {
        $cars = Car::query()
            ->from('cars as c')
            ->select(
                'c.id',
                'c.name',
                'u.name as creator',
                'c.created_at',
                'c.deleted_at',
            )
            ->join('users as u', 'u.id', 'c.created_by')
            ->whereNotNull('c.deleted_at') #SOFT DELETE
            ->orderBy('c.name');

        if ($request->name != null)
        {
            $cars = $cars->where('c.name', 'like', "%$request->name%");
        }

        if ($request->creator != null)
        {
            $cars = $cars->where('u.name', 'like', "%$request->creator%");
        }

        $cars = $cars->paginate(10);

        return view('dashboard.car.index-trash', compact('cars'));
    }

    public function edit($id)
    {
        $model = CarModel::query()
            ->where('id', $id)
            ->first();

        if (!$model)
            abort(404);

        $cars = $this->getCarForSelect();

        return view('dashboard.car-model.edit', compact('model', 'cars'));
    }

    private function getCarForSelect()
    {
        return Car::query()
            ->select(
                'id',
                'name',
            )
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
    }

}

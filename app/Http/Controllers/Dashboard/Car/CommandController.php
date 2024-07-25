<?php

namespace App\Http\Controllers\Dashboard\Car;

use App\Http\Controllers\Controller;
use App\Http\Utils\MessageUtil;
use App\Imports\CarImport;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CommandController extends Controller
{
    public function store(Request $request)
    {
        $check = Car::query()
            ->where(DB::raw('UPPER(name)'), strtoupper(trim($request->name)))
            ->exists();

        if ($check)
        {
            return to_route('dashboard.car.create')->with('fail', MessageUtil::MESSAGE_DUPLICATE);
        }

        Car::query()
            ->create([
                'name' => $request->name,
                'created_by' => auth()->user()->id
            ]);

        Cache::forget('car_select');

        return to_route('dashboard.car.create')->with('success', MessageUtil::MESSAGE_CREATED);
    }

    public function delete($id)
    {
        Car::query()
            ->where('id', $id)
            ->update([
                'deleted_at' => now()
            ]);

        Cache::forget('car_select');

        return redirect()->back()->with('success', MessageUtil::MESSAGE_DELETED);
    }

    public function deleteBack($id)
    {
        Car::query()
            ->where('id', $id)
            ->update([
                'deleted_at' => null
            ]);

        Cache::forget('car_select');

        return redirect()->back()->with('success', MessageUtil::MESSAGE_DELETE_CANCEL);
    }

    public function update(Request $request, $id)
    {
        $check = Car::query()
            ->where('name', $request->name)
            ->where('id', '!=', $id)
            ->exists();

        if ($check)
            return to_route('dashboard.car.edit', $id)->with('fail', MessageUtil::MESSAGE_DUPLICATE);

        Car::query()
            ->where('id', $id)
            ->update([
                'name' => $request->name
            ]);

        Cache::forget('car_select');

        return to_route('dashboard.car.edit', $id)->with('success', MessageUtil::MESSAGE_UPDATED);
    }

    public function import(Request $request)
    {
        Excel::import(new CarImport(auth()->user()->id), $request->cars);

        return back();
    }
}

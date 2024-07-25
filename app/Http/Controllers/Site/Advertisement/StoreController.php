<?php

namespace App\Http\Controllers\Site\Advertisement;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementInfo;
use App\Models\AdvertisementPhoto;
use App\Models\AdvertisementSupplier;
use App\Models\Ban;
use App\Models\Car;
use App\Models\CarSupplier;
use App\Models\City;
use App\Models\Color;
use App\Models\Currency;
use App\Models\FuelType;
use App\Models\Gear;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StoreController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'car_id' => 'required|integer|exists:cars,id',
            'year' => 'required|integer|min:1904|max:' . date('Y'),
            'supplier_ids' => 'nullable|array',
            'supplier_ids.*' => 'nullable|integer|exists:car_suppliers,id',
            'photos' => 'required|array',
            'photos.*' => 'required|image|max:5000|mimes:png,jpg,jpeg',
        ]);

        $advertisement = Advertisement::query()
            ->create([
                'body' => $request->body,
                'created_by' => auth()->guard('site')->user()->id,
                'car_id' => $request->car_id,
                'model_id' => $request->model_id,
                'price' => $request->price,
                'currency_id' => $request->currency_id,
            ]);

        $this->saveInfo($request, $advertisement->id);

        $this->saveSuppliers($request, $advertisement->id);

        $this->savePhotos($request, $advertisement->id);

        $this->sendNotificationToAdmin($request, $advertisement->id);

        return redirect()->back()->with('success', 'Elaniniza baxis kecirilecek');
    }

    private function saveInfo(Request $request, $advertisementId): void
    {
        AdvertisementInfo::query()
            ->create([
                'advertisement_id' => $advertisementId,
                'fuel_type_id' => $request->fuel_type_id,
                'gear_id' => $request->gear_id,
                'ban_id' => $request->ban_id,
                'year' => $request->year,
                'color_id' => $request->color_id,
                'distance' => $request->distance,
                'vin_code' => $request->vin_code,
                'city_id' => $request->city_id
            ]);
    }

    private function saveSuppliers(Request $request, $advertisementId): void
    {
        $insertSuppliers = [];
        foreach ($request->supplier_ids as $supplier_id)
        {
            $insertSuppliers[] = [
                'advertisement_id' => $advertisementId,
                'supplier_id' => $supplier_id
            ];

//            AdvertisementSupplier::query()
//                ->create([
//                    'advertisement_id' => $advertisement->id,
//                    'supplier_id' => $supplier_id
//                ]);
        }

        AdvertisementSupplier::query()
            ->insert($insertSuppliers);
    }

    private function savePhotos(Request $request, $advertisementId): void
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');

        $insertPhoto = [];

        foreach ($request->photos as $photo)
        {
            $filename = uniqid() . '.' . $photo->extension();
            $filenameWithUpload = "/storage/cars/$year/$month/$day/$filename";

            $photo->storeAs("public/cars/$year/$month/$day", $filename);

            $insertPhoto[] = [
                'advertisement_id' => $advertisementId,
                'photo' => $filenameWithUpload
            ];

//            AdvertisementPhoto::query()
//                ->create([
//                    'advertisement_id' => $advertisementId,
//                    'photo' => $filenameWithUpload
//                ]);
        }

        AdvertisementPhoto::query()
            ->insert($insertPhoto);
    }

    private function sendNotificationToAdmin(Request $request, $advertisementId)
    {
        $admins = User::query()
            ->select('id')
            ->get();

        foreach ($admins as $admin)
        {
            Notification::query()
                ->create([
                    'user_id' => $admin->id,
                    'title' => 'Yeni elan',
                    'body' => 'Elan metn',
                    'related_id' => $advertisementId,
                    'related_module' => 'App\Models\Advertisement'
                ]);
        }
    }
}

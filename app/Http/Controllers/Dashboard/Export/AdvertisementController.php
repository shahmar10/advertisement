<?php

namespace App\Http\Controllers\Dashboard\Export;

use App\Exports\AdvertisementExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdvertisementController extends Controller
{
    public function index()
    {
        return Excel::download(new AdvertisementExport(), 'advertisements.xlsx');
    }
}

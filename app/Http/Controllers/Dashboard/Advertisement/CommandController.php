<?php

namespace App\Http\Controllers\Dashboard\Advertisement;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementPhoto;
use App\Models\User;
use App\SelectData\AdvertisementStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class CommandController extends Controller
{
    public function approve($id)
    {
        $advertisement = Advertisement::query()
            ->from('advertisements as a')
            ->select(
                'a.id',
                'su.email'
            )
            ->where('a.status', 1)
            ->where('a.id', $id)
            ->join('site_users as su', 'su.id', 'a.created_by')
            ->first();

        if (!$advertisement)
            abort(404);

        Advertisement::query()
            ->where('id', $id)
            ->update([
                'status' => 2,
                'expired_at' => Carbon::now()->addMonth()->format('Y-m-d')
            ]);

        $body = 'Elaniniz derc olundu. Elanin linki: ';
        Mail::send('mail.standart', compact('body'), function ($mail) use ($advertisement) {
            $mail->to($advertisement->email)->subject('Elaniniz tesdiqlendi');
        });

        return redirect()->back();
    }

    public function reject($id)
    {
        $advertisement = Advertisement::query()
            ->from('advertisements as a')
            ->select(
                'a.id',
                'su.email'
            )
            ->where('a.status', 1)
            ->where('a.id', $id)
            ->join('site_users as su', 'su.id', 'a.created_by')
            ->first();

        if (!$advertisement)
            abort(404);

        Advertisement::query()
            ->where('id', $id)
            ->update([
                'status' => 0
            ]);

        $body = 'Elaniniz derc olunmadi.';
        Mail::send('mail.standart', compact('body'), function ($mail) use ($advertisement) {
            $mail->to($advertisement->email)->subject('Elaniniz derc olunmadi');
        });

        return redirect()->back();
    }
}

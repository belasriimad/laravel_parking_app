<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Place;
use App\Models\Sector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;

class PlaceController extends Controller
{
    //
    public function startParking(Request $request, Place $place)
    {
        $request->validate([
            'user_id' => [
                'required',
                'integer'
            ]
        ]);

        if ($place->where('user_id', $request->user_id)->whereNull('end_time')->exists()) {
            return response()->json([
                'error' => 'Car already parked!'
            ]);
        }
        
        $place->update([
            'user_id' => $request->user_id,
            'start_time' => now(),
            'availlable' => 0,
            'end_time' => NULL,
            'total_price' => NULL
        ]);

        $place->load('user', 'sector');
 
        return PlaceResource::make($place);
    }

    public function endParking(Place $place)
    {
        $place->update([
            'end_time' => now(),
            'availlable' => 1,
            'total_price' => $this->calculatePrice($place->sector_id, $place->start_time, $place->end_time),
        ]);
    
        return PlaceResource::make($place);
    }

    public function calculatePrice(int $sector_id, string $startTime, string $endTime = null): int
    {
        $start = new Carbon($startTime);
        $end = (!is_null($endTime)) ? new Carbon($endTime) : now();
 
        $totalTimeByMinutes = $end->diffInMinutes($start);

        $sector_hourly_price = Sector::find($sector_id)->hourly_price;
 
        if($totalTimeByMinutes > 60) {
            $priceByMinutes = $sector_hourly_price / 60;
 
            return ceil($totalTimeByMinutes * $priceByMinutes);
        }

        return $sector_hourly_price;
    }
}

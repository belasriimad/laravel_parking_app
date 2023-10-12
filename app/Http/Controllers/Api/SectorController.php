<?php

namespace App\Http\Controllers\Api;

use App\Models\Sector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectorResource;

class SectorController extends Controller
{
    //
    public function index()
    {
        return SectorResource::collection(Sector::all());
    }
}

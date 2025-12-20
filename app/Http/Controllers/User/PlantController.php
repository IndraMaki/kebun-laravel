<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plant;

class PlantController extends Controller
{
    public function show(Plant $tanaman)
    {
        return view('user.tanaman.show', ['plant' => $tanaman]);
    }
}
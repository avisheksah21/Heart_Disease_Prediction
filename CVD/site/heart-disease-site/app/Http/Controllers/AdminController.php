<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction; // ADDED: Import Prediction model

class AdminController extends Controller
{
    public function index()
    {
        $predictions = Prediction::with('user')->get();
        return view('admin', compact('predictions'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction; // ADDED: Import Prediction model

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all predictions in descending order by creation date
        $predictions_data = Prediction::orderBy('created_at', 'desc')->get();
        // Pass the predictions to the view
        // dd($predictions_data); 

        return view('admin.dashboard', compact('predictions_data'));
    }
}

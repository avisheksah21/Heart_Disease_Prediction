<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;

class AdminController extends Controller
{
    /**
     * Display a listing of the predictions for the admin dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Fetch all predictions in descending order
        $predictions_data = Prediction::orderBy('created_at', 'desc')->get();
        // Pass the predictions to the view
        return view('admin.dashboard', compact('predictions_data'));
    }
}

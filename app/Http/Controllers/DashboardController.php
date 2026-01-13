<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard user dengan list services
     */
    public function index()
    {
        $services = Service::all();
        
        return view('dashboard', compact('services'));
    }
}
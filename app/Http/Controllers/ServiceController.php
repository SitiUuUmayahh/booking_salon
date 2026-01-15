<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        $relatedServices = Service::where('id', '!=', $service->id)
            ->limit(3)
            ->get();
        
        return view('services.show', compact('service', 'relatedServices'));
    }
}

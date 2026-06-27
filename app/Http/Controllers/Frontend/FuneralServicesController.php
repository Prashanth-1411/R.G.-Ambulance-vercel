<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FuneralService;

class FuneralServicesController extends Controller
{
    public function index()
    {
        $services = FuneralService::where('status', true)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.funeral-services.index', compact('services'));
    }

    public function show(string $slug)
    {
        $service = FuneralService::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return view('frontend.funeral-services.show', compact('service'));
    }
}

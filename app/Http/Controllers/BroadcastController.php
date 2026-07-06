<?php

namespace App\Http\Controllers;

use App\Models\Broadcast;
use Illuminate\View\View;

class BroadcastController extends Controller
{
    public function index(): View
    {
        $broadcasts = Broadcast::with('store', 'product')
            ->where('is_live', true)
            ->latest()
            ->get();

        return view('broadcasts.index', compact('broadcasts'));
    }
}

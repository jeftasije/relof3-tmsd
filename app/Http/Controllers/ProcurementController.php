<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    public function index(Request $request)
    {
        $query = Procurement::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $procurements = $query->latest()->get();

        return view('procurements', compact('procurements'));
    }

}

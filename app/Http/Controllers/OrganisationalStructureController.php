<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganisationalStructure;

class OrganisationalStructureController extends Controller
{
    public function index() {
        $structure = OrganisationalStructure::latest()->first(); 
        return view('organisationalStructure', compact('structure'));
    }
}

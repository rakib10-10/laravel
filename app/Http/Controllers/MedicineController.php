<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine; // Make sure this is present

class MedicineController extends Controller
{
    public function index()
    {
        // This retrieves all records from the 'medicines' table
        $medicines = Medicine::all(); 
        
        // This passes the collection to the view
        return view('admin.medicines', compact('medicines'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Escrow;
use Illuminate\Http\Request;

class EscrowController extends Controller
{
    public function index(Request $request)
    {
        $query = Escrow::query();

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $escrows = $query->latest()->paginate(10);

        return view('escrows.index', compact('escrows'));
    }
    
    public function show(Escrow $escrow)
    {
        return view('escrows.show', compact('escrow'));
    }
}

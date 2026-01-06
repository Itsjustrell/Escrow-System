<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Escrow;
use App\Enums\EscrowStatus;

class EscrowController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Buyer: lihat escrow yang dia buat
        if ($user->hasRole('buyer')) {
            $escrows = Escrow::where('created_by', $user->id)
                ->latest()
                ->paginate(10);
        }
        // Seller: lihat escrow tempat dia jadi participant
        elseif ($user->hasRole('seller')) {
            $escrows = Escrow::whereHas('participants', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->where('role', 'seller');
            })->latest()->paginate(10);
        } else {
            abort(403);
        }

        return view('escrows.index', compact('escrows'));
    }


    public function show(Escrow $escrow)
    {
        $user = auth()->user();

        // Authorization: hanya participant, admin, atau arbiter boleh lihat
        $isParticipant = $escrow->participants()
            ->where('user_id', $user->id)
            ->exists();
            
        $hasAccess = $isParticipant || $user->hasRole('admin') || $user->hasRole('arbiter');

        abort_unless($hasAccess, 403);

        return view('escrows.show', compact('escrow'));
    }

    public function create()
    {
        abort_unless(auth()->user()->hasRole('buyer'), 403);

        $sellers = User::whereHas('roles', function ($q) {
            $q->where('name', 'seller');
        })->get();

        return view('escrows.create', compact('sellers'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasRole('buyer'), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'confirmation_window' => 'required|integer|min:1|max:7',
            'seller_id' => 'required|exists:users,id',
        ]);

        $escrow = Escrow::create([
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'status' => EscrowStatus::CREATED->value,
            'confirmation_window' => $validated['confirmation_window'],
            'created_by' => auth()->id(),
        ]);

        $escrow->participants()->createMany([
            [
                'user_id' => auth()->id(),
                'role' => 'buyer',
            ],
            [
                'user_id' => $validated['seller_id'],
                'role' => 'seller',
            ],
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Escrow created successfully');
    }
}

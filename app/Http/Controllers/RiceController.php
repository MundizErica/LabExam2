<?php

namespace App\Http\Controllers;

use App\Models\Rice;
use Illuminate\Http\Request;

class RiceController extends Controller
{
    public function index()
    {
        $riceItems = Rice::latest()->paginate(10);
        return view('rice.index', compact('riceItems'));
    }

    public function create()
    {
        return view('rice.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'price_per_kg'   => 'required|numeric|min:0',
            'stock_quantity_kg' => 'required|integer|min:0',
            'description'    => 'nullable|string|max:500',
        ]);

        Rice::create($validated);

        return redirect()->route('rice.index')
            ->with('success', 'Rice item added successfully.');
    }

    public function show(Rice $rice)
    {
        return view('rice.show', compact('rice'));
    }

    public function edit(Rice $rice)
    {
        return view('rice.edit', compact('rice'));
    }

    public function update(Request $request, Rice $rice)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'price_per_kg'   => 'required|numeric|min:0',
            'stock_quantity_kg' => 'required|integer|min:0',
            'description'    => 'nullable|string|max:500',
        ]);

        $rice->update($validated);

        return redirect()->route('rice.index')
            ->with('success', 'Rice item updated successfully.');
    }

    public function destroy(Rice $rice)
    {
        $rice->delete();
        return redirect()->route('rice.index')
            ->with('success', 'Rice item deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:unit-list|unit-create|unit-edit|unit-delete', ['only' => ['index','show']]);
        $this->middleware('permission:unit-create', ['only' => ['create','store']]);
        $this->middleware('permission:unit-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:unit-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $unit = Unit::withCount('user')->paginate(10);
        return view('unit.index', compact('unit'));
    }
    
    public function create()
    {
        return view('unit.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:unit',
        ]);
        
        Unit::create([
            'nama_unit' => $request->nama_unit,
        ]);
        
        return redirect()->route('unit.index')
            ->with('success', 'Unit berhasil dibuat.');
    }
    
    public function show($id)
    {
        $unit = Unit::with('user')->findOrFail($id);
        return view('unit.show', compact('unit'));
    }
    
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('unit.edit', compact('unit'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255|unique:unit,nama_unit,'.$id,
        ]);
        
        $unit = Unit::findOrFail($id);
        $unit->nama_unit = $request->nama_unit;
        $unit->save();
        
        return redirect()->route('unit.index')
            ->with('success', 'Unit berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        
        // Check if unit has users
        if ($unit->user()->count() > 0) {
            return redirect()->route('unit.index')
                ->with('error', 'Unit tidak dapat dihapus karena masih memiliki user.');
        }
        
        $unit->delete();
        
        return redirect()->route('unit.index')
            ->with('success', 'Unit berhasil dihapus.');
    }
}
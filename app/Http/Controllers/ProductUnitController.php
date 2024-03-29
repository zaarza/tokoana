<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = DB::table('product_units')
        ->when($request->search, function ($query, string $searchQuery) {
            $query->where('name', 'LIKE', '%' . $searchQuery . '%');
        })
        ->when(!$request->sort, function ($query, string $sortQuery) {
            $query->orderBy('name');
        })
        ->when($request->sort, function ($query, string $sortQuery) {
            switch ($sortQuery) {
                case "name":
                    $query->orderBy('name');
                    break;
                case "latest":
                    $query->latest();
                    break;
                case "oldest":
                    $query->oldest();
                    break;
                default:
                    $query->orderBy('name');
            }
        });

        return Inertia::render('Product/Units', [
            'user' => Auth::user(),
            'data' => $data->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ProductUnit::class);
        $validated = $request->validate([
            'name' => 'required|unique:product_units'
        ]);

        ProductUnit::create($validated);
        return redirect()->back()->with('add-product-unit-success', "New product unit has been added");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = DB::table('product_units')->find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductUnit $productUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $this->authorize('update', ProductUnit::class);
        $validated = $request->validate([
            'name' => 'required'
        ]);

        ProductUnit::find($id)->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorize('delete', ProductUnit::class);
        ProductUnit::destroy($id);
    }
}

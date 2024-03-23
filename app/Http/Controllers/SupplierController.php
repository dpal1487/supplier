<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\SupplierResource;

class SupplierController extends Controller
{
    public function getSupplier($id)
    {

        $supplier = Supplier::where(['id' => $id])->first();

        return new SupplierResource($supplier);
    }
    public function index(Request $request)
    {

        $suppliers = Supplier::latest();
        if (!empty($request->q)) {
            $suppliers = $suppliers
                ->where('supplier_name', 'like', "%$request->q%")
                ->orWhere('display_name', 'like', "%$request->q%");
        }
        if ($request->s !== 'all' && $request->s !== null) {
            $suppliers = $suppliers->where('status', (int)$request->s);
        }
        return Inertia::render('Supplier/Index', [
            'suppliers' => SupplierResource::collection($suppliers->paginate(10)->appends($request->all())),
        ]);
    }
}

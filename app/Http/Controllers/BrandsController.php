<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use PHPUnit\Framework\Constraint\Count;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Brands/Index', [
            'brands' => BrandResource::collection(
                Brand::latest()->paginate(config('app.pagination.count'))
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Brands/Create', [
            'defaultImagePath' => Brand::$defaultImagePath,
            'countries' => Country::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(BrandRequest $request): RedirectResponse
    {
        $this->save((new Brand), $request);

        return redirect()->route('brands.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): \Inertia\Response
    {
        $brand = Brand::findOrFail($id);

        return Inertia::render('Brands/Edit', [
            'brand' => $brand,
            'countries' => Country::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(BrandRequest $request, int $id): RedirectResponse
    {
        $brand = Brand::findOrFail($id);

        $this->save($brand, $request);

        //return back();
        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Brand::findOrFail($id)->delete();

        return redirect()->route('brands.index');
    }

    private function save(Brand $brand, BrandRequest $request): void
    {
        $brand->fill($request->validated())->save();

        if ($request->hasFile('image')) {
            $brand->updateImage($request->file('image'));
        }
    }
}

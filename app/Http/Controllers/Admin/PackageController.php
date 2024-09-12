<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function index()
    {
        return view('admin.package.index', ['packages' => Package::where('investment', 'enabled')->get()]);
    }

    public function indexAll()
    {
        return view('admin.package.index', ['packages' => Package::all()]);
    }

    public function create()
    {
        return view('admin.package.create');
    }

    public function investments(Package $package)
    {
        return view('admin.investment.index', ['investments' => $package->investments()->get(), 'type' => 'packages', 'id' => $package['id']]);
    }

    public function edit(Package $package)
    {
        return view('admin.package.edit', ['package' => $package]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:packages,name'],
            'min_amount' => ['required', 'numeric', 'gt:0'],
            'max_amount' => ['required', 'numeric', 'gt:0'],
            'duration' => ['required'],
            'roi' => ['required', 'numeric'],
            'milestone' => ['required', 'numeric'],
            'description' => ['required'],
            'image' => ['required', 'mimes:jpeg,jpg,png', 'max:1024'],
            'investment' => ['required', 'in:enabled,disabled'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Collect data from request
        $data = $request->only([
            'name',
            'min_amount',
            'max_amount',
            'roi',
            'duration',
            'milestone',
            'description',
            'investment',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadPackageImageAndReturnPathToSave($request->file('image'));
        }

        // Store package
        if (Package::create($data)) {
            return redirect()->route('admin.packages')->with('success', 'Package created successfully');
        }

        return back()->with('error', 'Error creating package');
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:packages,name,' . $id],
            'min_amount' => ['required', 'numeric', 'gt:0'],
            'max_amount' => ['required', 'numeric', 'gt:0'],
            'duration' => ['required'],
            'roi' => ['required', 'numeric'],
            'milestone' => ['required', 'numeric'],
            'description' => ['required'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:1024'],
            'investment' => ['required', 'in:enabled,disabled'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Find the package to update
        $package = Package::findOrFail($id);

        // Collect data from request
        $data = $request->only([
            'name',
            'min_amount',
            'max_amount',
            'roi',
            'duration',
            'milestone',
            'description',
            'investment',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($package->image) {
                $this->deletePackageImage($package->image);
            }
            // Upload new image
            $data['image'] = $this->uploadPackageImageAndReturnPathToSave($request->file('image'));
        }

        // Update package
        if ($package->update($data)) {
            return redirect()->route('admin.packages')->with('success', 'Package updated successfully');
        }

        return back()->with('error', 'Error updating package');
    }

    public function destroy(Package $package)
    {
        // check if package doesn't have investment
        if ($package->investments()->count() > 0){
            return back()->with('error', 'Can\'t delete package, investments already associated');
        }
        unlink($package['image']);
        if ($package->delete()){
            return redirect()->route('admin.packages')->with('success', 'Package deleted successfully');
        }
        return back()->with('error', 'Error deleting package');
    }

    protected function uploadPackageImageAndReturnPathToSave($image): string
    {
        $destinationPath = 'assets/packages'; // upload path
        $transferImage = \auth()->user()['id'].'-'. time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $transferImage);
        return $destinationPath ."/".$transferImage;
    }
}

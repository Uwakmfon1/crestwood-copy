<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function index()
    {
        return view('admin.package.index', ['packages' => Package::latest()->get()]);
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
        return view('admin.package.update', ['package' => $package]);
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
            'name' => ['required', 'unique:plans,name,' . $id],
            'roi' => ['required', 'numeric'],
            'description' => ['required'],
            'img' => ['sometimes'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Find the package to update
        $package = Plan::findOrFail($id);

        // Collect data from request
        $data = $request->only([
            'name',
            'roi',
            'description',
            'img',
        ]);

        // Update package
        if ($package->update($data)) {
            return redirect()->route('admin.saving.package')->with('success', 'Package updated successfully');
        }

        return back()->with('error', 'Error updating package');
    }

    public function updatePackage(Request $request, Package $package): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:packages,name,'.$package['id']],
            'min_amount' => ['required', 'numeric', 'gt:0'],
            'max_amount' => ['required', 'numeric', 'gt:0'],
            'duration' => ['required'],
            'roi' => ['required', 'numeric'],
            'milestone' => ['required', 'numeric'],
            'description' => ['required'],
            'image' => ['sometimes', 'mimes:jpeg,jpg,png', 'max:1024'],
            'investment' => ['required', 'in:enabled,disabled'],
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        $data = $request->except('image');

        if ($request->file('image')){
            $data['image'] = $this->uploadPackageImageAndReturnPathToSave($request['image']);
        }

        if ($package->update($data)){
            return redirect()->route('admin.packages')->with('success', 'Package updated successfully');
        }

        return back()->with('error', 'Error updating package');
    }

    public function togglePackage(Package $package): \Illuminate\Http\RedirectResponse
    {

        if($package->investment == 'enabled') {
            $package->update(['investment' => 'disabled']);
            return redirect()->route('admin.packages')->with('success', 'Package disabled successfully');
        } else {
            $package->update(['investment' => 'enabled']);
            return redirect()->route('admin.packages')->with('success', 'Package enabled successfully');
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

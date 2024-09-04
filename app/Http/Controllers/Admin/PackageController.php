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
            'price' => ['required', 'numeric', 'gt:0'],
            'min_duration' => ['required'],
            'daily_roi' => ['required', 'numeric'],
            'weekly_roi' => ['required', 'numeric'],
            'yearly_roi' => ['required', 'numeric'],
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
            'price',
            'min_duration',
            'daily_roi',
            'weekly_roi',
            'yearly_roi',
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

    public function update(Request $request, Package $package): \Illuminate\Http\RedirectResponse
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'price' => ['required', 'numeric', 'gt:0'],
            'min_duration' => ['required'],
            'daily_roi' => ['required', 'numeric'],
            'weekly_roi' => ['required', 'numeric'],
            'yearly_roi' => ['required', 'numeric'],
            'description' => ['required'],
            'investment' => ['required', 'in:enabled,disabled'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        // Collect data from request
        $data = $request->except('image');
        // Save file to folder if uploaded
        if ($request->file('image')){
            $data['image'] = $this->uploadPackageImageAndReturnPathToSave($request['image']);
        }
        // Store package
        if ($package->update($data)){
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

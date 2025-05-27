<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\Package;
use App\Services\Admin\PackageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PackageController extends Controller
{
    public function __construct(public PackageService $packageService) { }
    
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

    public function store(Request $request)
    {
        return $this->packageService->store($request);
    }

   
    public function update(Request $request, $id)
    {
        return $this->packageService->update($request, $id);
    }

    public function updatePackage(Request $request, Package $package)
    {
        return $this->packageService->updatePackage($request, $package);
    }
    
    public function togglePackage(Package $package)
    {
        return $this->packageService->updatePackage($package);
    }

   
    public function destroy(Package $package)
    {
        return $this->packageService->destroy($package);
    }

   

}

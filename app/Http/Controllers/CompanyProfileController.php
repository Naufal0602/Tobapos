<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Models\CompanyProfiles;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('welcome', [
            'companyProfile' => CompanyProfiles::first(), 
            'products' => Product::latest()->take(8)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Di CompanyProfileController.php
public function edit()
{
    // Ambil selalu data dengan ID 1
    $companyProfile = CompanyProfiles::findOrFail(1);
    return view('dashboard.company_profile.edit', compact('companyProfile'));
}


public function update(UpdateCompanyProfileRequest $request)
{
    try {
        $companyProfile = CompanyProfiles::findOrFail(1);
        $validatedData = $request->validated();

        // Handle gambar description
        if ($request->hasFile('img_description')) {
            if ($companyProfile->img_description) {
                Storage::delete('public/' . $companyProfile->img_description);
            }
            $validatedData['img_description'] = $request->file('img_description')->store('company_profile', 'public');
        }

        // Handle gambar home
        if ($request->hasFile('img_home')) {
            if ($companyProfile->img_home) {
                Storage::delete('public/' . $companyProfile->img_home);
            }
            $validatedData['img_home'] = $request->file('img_home')->store('company_profile', 'public');
        }

        $companyProfile->update($validatedData);

        return redirect()->route('dashboard.index')
            ->with('success', 'Profil perusahaan berhasil diperbarui');
    } catch (\Exception $e) {
        return redirect()->route('dashboard.index')
            ->with('error', 'Terjadi kesalahan saat memperbarui profil perusahaan: ' . $e->getMessage());
    }
}

}
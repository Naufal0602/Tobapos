<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('welcome', ['companyProfile' => CompanyProfile::first()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyProfile $companyProfile)
    {
        return view('dashboard.company_profile.edit', compact('companyProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyProfileRequest $request, CompanyProfile $companyProfile): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('img_about')) {
            if ($companyProfile->img_about) {
                Storage::disk('public')->delete($companyProfile->img_about);
            }

            $imagePath = $request->file('img_about')->store('company_profile', 'public');
            $validated['img_about'] = $imagePath;
        }

        if ($request->hasFile('img_home')) {
            if ($companyProfile->img_home) {
                Storage::disk('public')->delete($companyProfile->img_home);
            }

            $imagePath = $request->file('img_home')->store('company_profile', 'public');
            $validated['img_home'] = $imagePath;
        }

        $companyProfile->update($validated);

        return redirect()->route('dashboard.company_profile.edit', $companyProfile)
            ->with('success', 'Company Profile updated successfully');
    }
}

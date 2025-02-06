<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function sendMessage(Request $request): RedirectResponse
    {
        // Validasi input form
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Simpan data ke database
        Contact::create($request->all());

        return back()->with('success', 'Pesan Anda telah berhasil dikirim dan disimpan.');
    }
}

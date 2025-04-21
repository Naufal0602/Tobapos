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
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Simpan data ke database
        $contact = Contact::create($validated);

        return back()->with('success', 'Pesan Anda telah berhasil dikirim dan disimpan.');
    }

        public function index()
    {
        $contacts = Contact::all();

        return view('dashboard.contact.index', compact('contacts'));
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();
        
        return redirect()->route('dashboard.contact.index')
            ->with('success', 'Pesan kontak berhasil dihapus.');
    }
}

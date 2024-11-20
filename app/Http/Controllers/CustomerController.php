<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customers::all(); // Perbaikan di sini
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|max:15',
            'address' => 'nullable|max:500'
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);

        // Buat pelanggan baru
        Customers::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('customers.index')
            ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $customer = Customers::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        $customer = Customers::find($id);
        // Validasi data pelanggan
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email,'.$customer->id,
            'phone' => 'required|max:15',
            'address' => 'nullable|max:500'
        ]);

        // Update data pelanggan
        $customer->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $customer = Customers::find($id);
        try {
            // Hapus pelanggan
            $customer->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('customers.index')
                ->with('success', 'Pelanggan berhasil dihapus');
        } catch (\Exception $e) {
            // Tangani error jika pelanggan memiliki rental aktif
            return redirect()->route('customers.index')
                ->with('error', 'Tidak dapat menghapus pelanggan yang memiliki riwayat rental');
        }
    }

    public function show(Customer $customer)
    {
        // Tampilkan detail pelanggan dengan rental history
        $rentals = $customer->rentals;
        return view('customers.show', compact('customer', 'rentals'));
    }
}

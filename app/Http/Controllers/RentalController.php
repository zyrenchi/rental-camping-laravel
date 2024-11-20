<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Customers;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index()
    {
        // Ambil semua data rental dengan relasi
        $rentals = Rental::with(['customer', 'equipment'])->get();
        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        // Siapkan data untuk form rental
        $customers = Customers::all();
        $equipments = Equipment::where('available_stock', '>', 0)->get();
        return view('rentals.create', compact('customers', 'equipments'));
    }

    public function store(Request $request)
    {
        // Validasi data rental
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'equipment_id' => 'required|exists:equipment,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after:rental_date',
            'quantity' => 'required|integer|min:1'
        ]);

        // Ambil data equipment
        $equipment = Equipment::findOrFail($validatedData['equipment_id']);

        // Cek ketersediaan stok
        if ($equipment->available_stock < $validatedData['quantity']) {
            return back()->withErrors([
                'quantity' => 'Stok tidak mencukupi'
            ]);
        }

        // Hitung total harga
        $rentalDays = Carbon::parse($validatedData['rental_date'])
            ->diffInDays(Carbon::parse($validatedData['return_date']));
        $totalPrice = $equipment->daily_rate * $rentalDays * $validatedData['quantity'];

        // Buat rental baru
        $rental = Rental::create([
            'customer_id' => $validatedData['customer_id'],
            'equipment_id' => $validatedData['equipment_id'],
            'rental_date' => $validatedData['rental_date'],
            'return_date' => $validatedData['return_date'],
            'quantity' => $validatedData['quantity'],
            'total_price' => $totalPrice,
            'status' => 'ongoing'
        ]);

        // Update stok peralatan
        $equipment->decrement('available_stock', $validatedData['quantity']);

        return redirect()->route('rentals.index')
            ->with('success', 'Rental berhasil dibuat');
    }

    public function returnEquipment(Rental $rental)
    {
        // Cek status rental
        if ($rental->status === 'returned') {
            return back()->with('error', 'Alat sudah dikembalikan');
        }

        // Kembalikan stok
        $equipment = $rental->equipment;
        $equipment->increment('available_stock', $rental->quantity);

        // Update status rental
        $rental->update([
            'status' => 'returned'
        ]);

        return redirect()->route('rentals.index')
            ->with('success', 'Alat berhasil dikembalikan');
    }

    public function destroy(Rental $rental)
    {
        try {
            // Batalkan rental jika belum dikembalikan
            if ($rental->status === 'ongoing') {
                // Kembalikan stok
                $equipment = $rental->equipment;
                $equipment->increment('available_stock', $rental->quantity);
            }

            // Hapus rental
            $rental->delete();

            return redirect()->route('rentals.index')
                ->with('success', 'Data rental berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus rental');
        }
    }
}

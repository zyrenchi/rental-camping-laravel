@extends('main')

@section('content')
<div class="container">
    <h1 class="mb-4">Buat Rental Baru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rentals.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="customer_id" class="form-label">Pelanggan</label>
            <select class="form-select" id="customer_id" name="customer_id" required>
                <option value="">Pilih Pelanggan</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="equipment_id" class="form-label">Alat Camping</label>
            <select class="form-select" id="equipment_id" name="equipment_id" required>
                <option value="">Pilih Alat</option>
                @foreach($equipments as $equipment)
                    <option value="{{ $equipment->id }}">
                        {{ $equipment->name }} (Stok: {{ $equipment->available_stock }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="rental_date" class="form-label">Tanggal Rental</label>
            <input type="date" class="form-control" id="rental_date" name="rental_date" required>
        </div>
        <div class="mb-3">
            <label for="return_date" class="form-label">Tanggal Kembali</label>
            <input type="date" class="form-control" id="return_date" name="return_date" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Rental</button>
    </form>
</div>
@endsection

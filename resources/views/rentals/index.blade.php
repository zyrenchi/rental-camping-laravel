@extends('main')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Rental</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">
        Tambah Rental Baru
    </a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Alat</th>
                <th>Tanggal Rental</th>
                <th>Tanggal Kembali</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
            <tr>
                <td>{{ $rental->customer->name }}</td>
                <td>{{ $rental->equipment->name }}</td>
                <td>{{ $rental->rental_date }}</td>
                <td>{{ $rental->return_date }}</td>
                <td>Rp. {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                <td>{{ $rental->status }}</td>
                <td>
                    <form action="{{ route('rentals.return', $rental->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pengembalian?')">
                            Kembalikan
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

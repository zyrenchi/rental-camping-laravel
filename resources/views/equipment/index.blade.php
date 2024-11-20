@extends('main')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Alat Camping</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('equipment.create') }}" class="btn btn-primary mb-3">
        Tambah Alat Baru
    </a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Alat</th>
                <th>Kategori</th>
                <th>Tarif Harian</th>
                <th>Stok Tersedia</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipments as $equipment)
            <tr>
                <td>{{ $equipment->name }}</td>
                <td>{{ $equipment->category }}</td>
                <td>Rp. {{ number_format($equipment->daily_rate, 0, ',', '.') }}</td>
                <td>{{ $equipment->available_stock }}</td>
                <td>
                    <a href="{{ route('equipment.edit', $equipment->id) }}" class="btn btn-sm btn-warning">
                        Edit
                    </a>
                    <form action="{{ route('equipment.destroy', $equipment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

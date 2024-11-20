@extends('main')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Alat Camping Baru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('equipment.update', $equipment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Alat</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$equipment->name}}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $equipment->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Pilih Kategori</option>
                <option value="Tenda" {{ $equipment->category === 'Tenda' ? 'selected' : '' }}>Tenda</option>
                <option value="Sleeping Bag" {{ $equipment->category === 'Sleeping Bag' ? 'selected' : '' }}>Sleeping Bag</option>
                <option value="Peralatan Masak" {{ $equipment->category === 'Peralatan Masak' ? 'selected' : '' }}>Peralatan Masak</option>
                <option value="Perlengkapan Lainnya" {{ $equipment->category === 'Perlengkapan Lainnya' ? 'selected' : '' }}>Perlengkapan Lainnya</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="daily_rate" class="form-label">Tarif Harian (Rp)</label>
            <input type="number" class="form-control" id="daily_rate" name="daily_rate" value="{{$equipment->daily_rate}}"  required>
        </div>
        <div class="mb-3">
            <label for="total_stock" class="form-label">Jumlah Stok</label>
            <input type="number" class="form-control" id="total_stock" name="total_stock" value="{{$equipment->total_stock}}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Alat</button>
    </form>
</div>
@endsection

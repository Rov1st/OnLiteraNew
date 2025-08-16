{{-- <x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data guru') }}
        </h2>
    </x-slot>

    <div class="container">
        <h2>Edit Kendaraan</h2>
        <form action="{{ route('BukuOnline.update', $BukuOnline->id_buku) }}" method="post"
            enctype="multipart/form-data">
            @method('put')
            {{ csrf_field() }}

            <div class="mb-3">
                <label for="kategori_id" class="form-label">ID Buku</label>
                <input type="text" name="id_buku" class="form-control" value="{{ $BukuOnline->id_buku }}" readonly>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ $BukuOnline->judul }}" required>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ $BukuOnline->kategori }}" required>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Genre</label>
                <input type="text" name="genre" class="form-control" value="{{ $BukuOnline->genre }}" required>
            </div>

            <div class="mb-3">
                <label for="penjelasan" class="form-label">Penjelasan</label>
                <textarea name="penjelasan" class="form-control" rows="4"
                    required>{{ $BukuOnline->penjelasan }}</textarea>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Buku URL</label>
                <input type="text" name="buku_url" class="form-control" value="{{ $BukuOnline->buku_url }}" required>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Penulis</label>
                <input type="text" name="penulis" class="form-control" value="{{ $BukuOnline->penulis }}" required>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Sumber</label>
                <input type="text" name="sumber" class="form-control" value="{{ $BukuOnline->sumber }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ url('BukuOnline') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-app-layout> --}}

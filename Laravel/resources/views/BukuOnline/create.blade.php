{{-- <x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Data Guru') }}
      </h2>
    </x-slot>

    <div class="container">
      <br>
      <h2>Tambah Data Buku</h2>
      <br>
      <form action="{{ route('BukuOnline.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="judul" class="form-label">Judul</label>
          <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="kategori" class="form-label">Kategori</label>
          <input type="text" name="kategori" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="genre" class="form-label">Genre</label>
          <input type="text" name="genre" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="penjelasan" class="form-label">Penjelasan</label>
         <textarea name="penjelasan" id="penjelasan" rows="5" cols="30"></textarea>
        </div>

        <div class="mb-3">
          <label for="buku-url" class="form-label">Buku Url</label>
          <input type="text" name="buku_url" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="penulis" class="form-label">Penulis</label>
          <input type="text" name="penulis" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="sumber" class="form-label">Sumber</label>
          <input type="text" name="sumber" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('BukuOnline.index') }}" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </x-app-layout> --}}

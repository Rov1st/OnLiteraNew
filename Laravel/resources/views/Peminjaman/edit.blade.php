<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data user') }}
        </h2>
    </x-slot>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <h2>Edit Kendaraan</h2>
        <form action="{{ route('Peminjaman.update', $Peminjaman->id_peminjaman) }}" method="post"
            enctype="multipart/form-data">
            @method('put')
            {{ csrf_field() }}

            <div class="mb-3">
                <label for="tanggal_harus_kembali_id" class="form-label">ID Peminjaman</label>
                <input type="text" name="id_peminjaman" class="form-control" value="{{ $Peminjaman->id_peminjaman }}" readonly>
            </div>

            <div class="mb-3">
                <label for="tanggal_harus_kembali_id" class="form-label">tanggal_pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control" value="{{ $Peminjaman->tanggal_pinjam }}" required>
            </div>

            <div class="mb-3">
                <label for="tanggal_harus_kembali_id" class="form-label">tanggal_harus_kembali</label>
                <input type="date" name="tanggal_harus_kembali" class="form-control" value="{{ $Peminjaman->tanggal_harus_kembali }}" required>
            </div>

             <div class="mb-3">
    <label for="id_user" class="form-label">User</label>
    <select class="form-select form-select-lg" name="id_user" id="id_user">
        @foreach($user as $row)
            <option value="{{ $row->id }}" {{ $Peminjaman->id_user == $row->id ? 'selected' : '' }}>
                {{ $row->name }}
            </option>
        @endforeach
    </select>
</div>


            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ url('Peminjaman') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-app-layout>

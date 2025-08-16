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
        <form action="{{ route('Pengembalian.update', $Pengembalian->id_pengembalian) }}" method="post"
            enctype="multipart/form-data">
            @method('put')
            {{ csrf_field() }}

            <div class="mb-3">
                <label for="id_pengembalian" class="form-label">ID Pengembalian</label>
                <input type="text" name="id_pengembalian" class="form-control"
                    value="{{ $Pengembalian->id_pengembalian }}" readonly>
            </div>

            <div class="mb-3">
                <label for="id_peminjaman" class="form-label">ID Peminjaman</label>
                <select class="form-select form-select-lg" name="id_peminjaman" id="id_peminjaman">
                    @foreach($Peminjaman as $row)
                        <option value="{{ $row->id_peminjaman }}" {{ $Pengembalian->id_peminjaman == $row->id_peminjaman ? 'selected' : '' }}>
                            {{ $row->id_peminjaman }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" class="form-control"
                    value="{{ $Pengembalian->tanggal_kembali }}" required>
            </div>

            <div class="mb-3">
                <label for="tanggal_harus_kembali_id" class="form-label">tanggal_harus_kembali</label>
                <input type="date" name="tanggal_harus_kembali" class="form-control"
                    value="{{ $Pengembalian->tanggal_harus_kembali }}" required>
            </div>

            <div class="mb-3">
                <label for="denda" class="form-label">Denda</label>
                <input type="number" name="denda" class="form-control"
                    value="{{ $Pengembalian->denda }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ url('Pengembalian') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-app-layout>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin OnLitera - Detail Peminjaman</title>
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="{{ asset('css/genre.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex bg-info justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-light">DataTables Detail Peminjaman</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form method="GET" action="{{ route('DetailPeminjaman.index') }}"
                                    class="form-inline mb-3">
                                    <label for="status" class="mr-2">Filter Status:</label>
                                    <select name="status" id="status" class="form-control mr-2"
                                        onchange="this.form.submit()">
                                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua</option>
                                        <option value="Menunggu Konfirmasi" {{ $status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                        <option value="Dikonfirmasi" {{ $status == 'Dikonfirmasi' ? 'selected' : '' }}>
                                            Dikonfirmasi</option>
                                        <option value="Ditolak" {{ $status == 'Ditolak' ? 'selected' : '' }}>Ditolak
                                        </option>
                                        <option value="Dikembalikan" {{ $status == 'Dikembalikan' ? 'selected' : '' }}>
                                            Dikembalikan</option>
                                        <option value="Terlambat" {{ $status == 'Terlambat' ? 'selected' : '' }}>
                                            Terlambat</option>
                                    </select>
                                </form>

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Peminjaman</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Harus Kembali</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Status</th>
                                            <th>Nama</th>
                                            <th>Buku</th>
                                            <th>Stok</th>
                                            <th>Denda</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($peminjaman as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->id_peminjaman }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d-m-Y H:i') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($row->tanggal_harus_kembali)->format('d-m-Y H:i') }}
                                                </td>
                                                <td>
                                                    @if($row->pengembalian && $row->pengembalian->tanggal_kembali)
                                                        {{ \Carbon\Carbon::parse($row->pengembalian->tanggal_kembali)->format('d-m-Y H:i') }}
                                                    @else
                                                        <span class="text-danger">Belum dikembalikan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->status === 'Menunggu Konfirmasi')
                                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                                    @elseif($row->status === 'Dikonfirmasi')
                                                        <span class="badge badge-primary">Dikonfirmasi</span>
                                                    @elseif($row->status === 'Ditolak')
                                                        <span class="badge badge-danger">Ditolak</span>
                                                    @elseif($row->status === 'Dikembalikan')
                                                        <span class="badge badge-success">Dikembalikan</span>
                                                    @elseif($row->status === 'Terlambat')
                                                        <span class="badge badge-danger">Terlambat</span>
                                                    @elseif($row->status === 'Dibatalkan')
                                                        <span class="badge badge-info">Dibatalkan</span>
                                                    @endif
                                                </td>
                                                <td>{{ $row->user->name ?? 'User tidak ditemukan' }}</td>
                                                <td>
                                                    @foreach($row->detailPeminjaman as $detail)
                                                        {{ $detail->id_buku }} -
                                                        {{ $detail->buku->judul ?? 'Buku tidak ditemukan' }}<br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($row->detailPeminjaman as $detail)
                                                        {{ $detail->stok }}<br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $row->pengembalian->denda ?? 0 }}</td>
                                                <td>
                                                    @if($row->status === 'Menunggu Konfirmasi')
                                                        <!-- Tombol Konfirmasi -->
                                                        <form
                                                            action="{{ route('DetailPeminjaman.konfirmasi', $row->id_peminjaman) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                onclick="return confirm('Konfirmasi peminjaman ini?')">Konfirmasi</button>
                                                        </form>

                                                        <!-- Tombol Tolak -->
                                                        <form
                                                            action="{{ route('DetailPeminjaman.tolak', $row->id_peminjaman) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Tolak peminjaman ini?')">Tolak</button>
                                                        </form>

                                                    @elseif($row->status === 'Terlambat')
                                                        @if(!$row->pengembalian || !$row->pengembalian->tanggal_kembali)
                                                            <!-- Step 1: Input tanggal kembali -->
                                                            <button class="btn btn-info btn-sm btn-edit"
                                                                data-id="{{ $row->id_peminjaman }}"
                                                                data-pinjam="{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('Y-m-d\TH:i') }}"
                                                                data-kembali="{{ \Carbon\Carbon::parse($row->tanggal_harus_kembali)->format('Y-m-d\TH:i') }}"
                                                                data-status="Terlambat"
                                                                data-tanggalkembali="{{ $row->pengembalian && $row->pengembalian->tanggal_kembali ? \Carbon\Carbon::parse($row->pengembalian->tanggal_kembali)->format('Y-m-d\TH:i') : '' }}"
                                                                data-user="{{ $row->user->id }}"
                                                                data-buku='@json($row->detailPeminjaman->map(fn($d) => ["id_buku" => $d->id_buku, "stok" => $d->stok]))'
                                                                data-denda="{{ $row->pengembalian->denda ?? 0 }}">
                                                                Pengembalian
                                                            </button>
                                                        @else
                                                            <!-- Step 2: Bayar denda -->
                                                            <form
                                                                action="{{ route('DetailPeminjaman.lunas', $row->id_peminjaman) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Bayar Denda?')">Bayar Denda</button>
                                                            </form>
                                                        @endif

                                                    @elseif($row->status === 'Dikonfirmasi')
                                                        <!-- Tombol Pengembalian -->
                                                        <button class="btn btn-info btn-sm btn-edit"
                                                            data-id="{{ $row->id_peminjaman }}"
                                                            data-pinjam="{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('Y-m-d\TH:i') }}"
                                                            data-kembali="{{ \Carbon\Carbon::parse($row->tanggal_harus_kembali)->format('Y-m-d\TH:i') }}"
                                                            data-status="{{ $row->status }}"
                                                            data-tanggalkembali="{{ $row->pengembalian && $row->pengembalian->tanggal_kembali ? \Carbon\Carbon::parse($row->pengembalian->tanggal_kembali)->format('Y-m-d\TH:i') : '' }}"
                                                            data-user="{{ $row->user->id }}" data-buku='@json($row->detailPeminjaman->map(fn($d) => [
                                                                "id_buku" => $d->id_buku,
                                                                "stok" => $d->stok
                                                            ]))' data-denda="{{ $row->pengembalian->denda ?? 0 }}">
                                                            Pengembalian
                                                        </button>
                                                        <!-- Tombol Hapus -->
                                                    @else
                                                        <form action="{{ url('DetailPeminjaman/' . $row->id_peminjaman) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Input data -->
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-left">
                                            <h1 class="h4 text-gray-900 mb-4">Input Data Peminjaman</h1>
                                        </div>
                                        <form class="user" action="{{ route('DetailPeminjaman.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="tanggal_pinjam">Tanggal Pinjam</label>
                                                <input type="datetime-local" class="form-control form-control-user"
                                                    name="tanggal_pinjam" id="tanggal_pinjam"
                                                    placeholder="Tanggal Pinjam" required>
                                            </div>
                                            <div class="form-group">
                                                <select name="id_user" class="form-control rounded-pill" required>
                                                    <option value="">--- Pilih Peminjam ---</option>
                                                    @foreach ($users as $row)
                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <hr>
                                            <h5>Pilih Buku</h5>

                                            <!-- Template Buku (Hidden) -->
                                            <div id="buku-template" style="display:none;">
                                                <div class="form-group buku-item"
                                                    style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <select name="id_buku[]" class="form-control">
                                                                <option value="">-- Pilih Buku --</option>
                                                                @foreach($buku as $b)
                                                                    <option value="{{ $b->id_buku }}">{{ $b->judul }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="number" class="form-control" name="stok[]"
                                                                placeholder="Stok" min="1">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm btn-hapus-buku">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="buku-wrapper"></div>
                                            <button type="button" id="tambah-buku" class="btn btn-secondary">+ Tambah
                                                Buku</button>
                                            <br><br>
                                            <button type="submit"
                                                class="btn btn-info btn-user btn-block">Simpan</button>
                                            <a href="{{ route('DetailPeminjaman.index') }}"
                                                class="btn btn-danger btn-user btn-block">Ulang</a>
                                        </form>
                                        <hr>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-left">
                                            <h1 class="h4 text-gray-900 mb-4">Pengembalian</h1>
                                        </div>
                                        <form id="editForm" class="user" action="" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    name="id_peminjaman" id="id_peminjaman" placeholder="ID Peminjaman"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <input type="datetime-local" class="form-control form-control-user"
                                                    name="tanggal_pinjam" id="tanggal_pinjam_edit"
                                                    placeholder="Tanggal Pinjam" hidden>
                                            </div>
                                            <div class="form-group">
                                                <input type="datetime-local" class="form-control form-control-user"
                                                    name="tanggal_harus_kembali" id="tanggal_harus_kembali_edit"
                                                    placeholder="Tanggal_harus_kembali" hidden>
                                            </div>
                                            <div class="form-group">
                                                <select name="id_user" id="id_user" class="form-control rounded-pill"
                                                    required>
                                                    <option value="">--- Peminjam ---</option>
                                                    @foreach ($users as $row)
                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal_kembali">Tanggal Kembali</label>
                                                <input type="datetime-local" class="form-control form-control-user"
                                                    name="tanggal_kembali" id="tanggal_kembali"
                                                    placeholder="Tanggal Kembali">
                                            </div>

                                            <hr>
                                            <h5>Pilih Buku</h5>
                                            <div id="buku-wrapper-edit"></div>
                                            <button type="button" id="tambah-buku-edit" class="btn btn-secondary">+
                                                Tambah Buku</button>
                                            <br><br>

                                            <div class="form-group">
                                                <label for="denda">Denda (Rp)</label>
                                                <input type="number" id="denda_display" class="form-control"
                                                    value="0" readonly>
                                            </div>

                                            <button type="submit"
                                                class="btn btn-info btn-user btn-block">Perbarui</button>
                                            <a href="{{ url('DetailPeminjaman') }}"
                                                class="btn btn-danger btn-user btn-block">Ulang</a>
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
        // Ambil template buku
        function getBukuTemplate() {
            return document.querySelector('#buku-template .buku-item').cloneNode(true);
        }

        // Tambahkan event listener hapus
        function addRemoveListener(item) {
            const removeBtn = item.querySelector('.btn-hapus-buku');
            if (removeBtn) {
                removeBtn.addEventListener('click', function () {
                    const wrapper = item.parentElement;
                    if (wrapper.children.length > 1) {
                        item.remove();
                    } else {
                        alert('Minimal harus ada 1 buku');
                    }
                });
            }
        }

        // Hitung denda realtime berdasarkan tanggal kembali
        function hitungDendaRealtime() {
            const kembaliInput = document.getElementById('tanggal_kembali');
            const harusKembaliInput = document.getElementById('tanggal_harus_kembali_edit');
            const dendaDisplay = document.getElementById('denda_display');
            const statusInput = document.getElementById('status_edit');

            if (!kembaliInput || !harusKembaliInput || !dendaDisplay) return;

            kembaliInput.addEventListener("change", function () {
                if (this.value && harusKembaliInput.value) {
                    let tanggalHarusKembali = new Date(harusKembaliInput.value);
                    let tanggalKembali = new Date(this.value);

                    // Hitung selisih dalam milidetik
                    let diffTime = tanggalKembali - tanggalHarusKembali;
                    // Konversi ke hari (dibulatkan ke bawah)
                    let terlambat = Math.floor(diffTime / (1000 * 60 * 60 * 24));

                    // Jika lebih kecil dari 0, berarti belum lewat deadline
                    if (terlambat < 0) terlambat = 0;

                    // Denda = 5000 * jumlah hari terlambat
                    let totalDenda = terlambat * 5000;

                    dendaDisplay.value = totalDenda;
                }
            });
        }

        // Auto set tanggal harus kembali +5 hari
        function setTanggalHarusKembali(pinjamInputId, kembaliInputId) {
            const pinjamInput = document.getElementById(pinjamInputId);
            const kembaliInput = document.getElementById(kembaliInputId);

            if (!pinjamInput || !kembaliInput) return;

            pinjamInput.addEventListener("change", function () {
                if (this.value) {
                    let pinjamDate = new Date(this.value);
                    pinjamDate.setDate(pinjamDate.getDate() + 5);

                    let year = pinjamDate.getFullYear();
                    let month = String(pinjamDate.getMonth() + 1).padStart(2, '0');
                    let day = String(pinjamDate.getDate()).padStart(2, '0');
                    let hours = String(pinjamDate.getHours()).padStart(2, '0');
                    let minutes = String(pinjamDate.getMinutes()).padStart(2, '0');

                    // Set hidden input tanggal harus kembali
                    document.getElementById('tanggal_harus_kembali').value = `${year}-${month}-${day}T${hours}:${minutes}`;
                }
            });
        }

        // ================= MAIN =================
        document.addEventListener("DOMContentLoaded", function () {
            // Event listener untuk tombol edit
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    const form = document.getElementById('editForm');
                    const id = this.dataset.id;
                    const pinjam = this.dataset.pinjam;
                    const kembali = this.dataset.kembali;
                    const tanggalKembali = this.dataset.tanggalkembali;
                    const status = this.dataset.status;
                    const user = this.dataset.user;
                    const bukuList = JSON.parse(this.dataset.buku || "[]");
                    const denda = this.dataset.denda || 0;

                    form.action = `/DetailPeminjaman/${id}`;
                    document.getElementById('id_peminjaman').value = id;
                    document.getElementById('tanggal_pinjam_edit').value = pinjam;
                    document.getElementById('tanggal_harus_kembali_edit').value = kembali;
                    document.getElementById('id_user').value = user;
                    document.getElementById('denda_display').value = denda;

                    if (document.getElementById('tanggal_kembali')) {
                        document.getElementById('tanggal_kembali').value = tanggalKembali || "";
                    }

                    // isi wrapper buku
                    let wrapper = document.getElementById('buku-wrapper-edit');
                    wrapper.innerHTML = '';
                    if (bukuList.length > 0) {
                        bukuList.forEach(item => {
                            let newItem = getBukuTemplate();
                            newItem.querySelector('select').value = item.id_buku;
                            newItem.querySelector('input[name="stok[]"]').value = item.stok;
                            addRemoveListener(newItem);
                            wrapper.appendChild(newItem);
                        });
                    } else {
                        let newItem = getBukuTemplate();
                        addRemoveListener(newItem);
                        wrapper.appendChild(newItem);
                    }
                });
            });

            // Jalankan hitung denda realtime
            hitungDendaRealtime();

            // Set tanggal harus kembali otomatis
            setTanggalHarusKembali("tanggal_pinjam");

            // Inisialisasi buku pertama
            let wrapper = document.getElementById('buku-wrapper');
            if (wrapper && wrapper.children.length === 0) {
                let firstItem = getBukuTemplate();
                addRemoveListener(firstItem);
                wrapper.appendChild(firstItem);
            }

            // Tombol tambah buku (form tambah)
            const tambahBukuBtn = document.getElementById('tambah-buku');
            if (tambahBukuBtn) {
                tambahBukuBtn.addEventListener('click', function () {
                    let wrapper = document.getElementById('buku-wrapper');
                    let newItem = getBukuTemplate();
                    addRemoveListener(newItem);
                    wrapper.appendChild(newItem);
                });
            }

            // Tombol tambah buku (form edit)
            const tambahBukuEditBtn = document.getElementById('tambah-buku-edit');
            if (tambahBukuEditBtn) {
                tambahBukuEditBtn.addEventListener('click', function () {
                    let wrapper = document.getElementById('buku-wrapper-edit');
                    let newItem = getBukuTemplate();
                    addRemoveListener(newItem);
                    wrapper.appendChild(newItem);
                });
            }

            validasiTanggalKembali();
        });

        function validasiTanggalKembali() {
            const pinjamInput = document.getElementById('tanggal_pinjam_edit');
            const kembaliInput = document.getElementById('tanggal_kembali');

            if (!pinjamInput || !kembaliInput) return;

            // Set minimal tanggal kembali = tanggal pinjam
            kembaliInput.min = pinjamInput.value;

            kembaliInput.addEventListener("change", function () {
                if (this.value < pinjamInput.value) {
                    alert("Tanggal kembali tidak boleh lebih awal dari tanggal pinjam!");
                    this.value = pinjamInput.value;
                }
            });
        }

    </script>
</body>

</html>

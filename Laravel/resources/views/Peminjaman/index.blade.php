<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin OnLitera - Peminjaman</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                            <h6 class="m-0 font-weight-bold text-light">DataTables Peminjaman</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Peminjaman</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Harus Kembali</th>
                                            <th>Status</th>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Peminjaman as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->id_peminjaman }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d-m-Y H:i') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($row->tanggal_harus_kembali)->format('d-m-Y H:i') }}
                                                </td>
                                                <td>{{ $row->status }}</td>
                                                <td>{{ $row->user->name ?? 'User tidak ditemukan' }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm btn-edit"
                                                        data-id="{{ $row->id_peminjaman }}"
                                                        data-pinjam="{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('Y-m-d\TH:i') }}"
                                                        data-kembali="{{ \Carbon\Carbon::parse($row->tanggal_harus_kembali)->format('Y-m-d\TH:i') }}"
                                                        data-status="{{ $row->status }}"
                                                        data-user="{{ $row->user->id }}">Edit</button>
                                                    <form action="{{ url('Peminjaman/' . $row->id_peminjaman) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Input data -->
                    <!-- Kolom Kiri (Form) -->
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-left">
                                            <h1 class="h4 text-gray-900 mb-4">Tambah Data</h1>
                                        </div>
                                        <form class="user" action="{{ route('Peminjaman.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="tanggal_pinjam">Tanggal Pinjam</label>
                                                <input type="datetime-local" class="form-control form-control-user"
                                                    name="tanggal_pinjam" placeholder="Tanggal Pinjam" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal_harus_kembali">Tanggal Harus Kembali</label>
                                                <input type="datetime-local" class="form-control form-control-user"
                                                    name="tanggal_harus_kembali" placeholder="Tanggal Harus Kembali"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <select name="status" class="form-control rounded-pill" required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Selesai">Selesai</option>
                                                    <option value="Belum">Belum
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select name="id_user" class="form-control select2" required>
                                                    <option value="">-- Pilih --</option>
                                                    @foreach ($user as $row)
                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-info btn-user btn-block">Simpan</button>
                                            <a href="{{ route('Peminjaman.index') }}"
                                                class="btn btn-danger btn-user btn-block">
                                                Ulang
                                            </a>
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-left">
                                            <h1 class="h4 text-gray-900 mb-4">Edit Data</h1>
                                        </div>
                                        <form id="editForm" class="user" action="" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                name="id_peminjaman" id="id_peminjaman" placeholder="ID Peminjaman"
                                                readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal_pinjam">Tanggal Pinjam</label>
                                                <input type="datetime-local" class="form-control form-control-user"
                                                name="tanggal_pinjam" id="tanggal_pinjam"
                                                placeholder="Tanggal Pinjam" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal_harus_kembali">Tanggal Harus Kembali</label>
                                                <input type="datetime-local" class="form-control form-control-user"
                                                    name="tanggal_harus_kembali" id="tanggal_harus_kembali"
                                                    placeholder="Tanggal harus kembali" required>
                                            </div>
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control rounded-pill"
                                                    required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Selesai">Selesai</option>
                                                    <option value="Belum">Belum
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select name="id_user" id="id_user" class="form-control select2"
                                                    required>
                                                    <option value="">-- Pilih --</option>
                                                    @foreach ($user as $row)
                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-info btn-user btn-block">Perbarui</button>
                                            <a href="{{ url('Peminjaman') }}" class="btn btn-danger btn-user btn-block">
                                                Ulang
                                            </a>
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('layouts.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />

    <script>
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function () {
                const form = document.getElementById('editForm');

                // Ambil data dari atribut tombol
                const id = this.dataset.id;
                const pinjam = this.dataset.pinjam;
                const kembali = this.dataset.kembali;
                const status = this.dataset.status;
                const user = this.dataset.user;

                // Masukkan data ke form
                form.action = `/Peminjaman/${id}`;
                document.getElementById('id_peminjaman').value = id;
                document.getElementById('tanggal_pinjam').value = pinjam;
                document.getElementById('tanggal_harus_kembali').value = kembali;
                document.getElementById('status').value = status;
                document.getElementById('id_user').value = user;
            });
        });

        $('.select2').select2({
            theme: 'bootstrap4',  // PENTING: Pakai theme bootstrap4
            placeholder: "Ketik untuk mencari Nama...",
            allowClear: true,
            width: '100%'
        });
    </script>

</body>

</html>

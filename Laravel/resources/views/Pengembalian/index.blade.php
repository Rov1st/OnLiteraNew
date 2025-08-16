<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin OnLitera - Pengembalian</title>

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
                        <div class="card-header py-3 d-flex justify-content-between bg-info align-items-center">
                            <h6 class="m-0 font-weight-bold text-light">DataTables Pengembalian</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pengembalian ID</th>
                                            <th>Peminjaman ID</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Tanggal harus kembali</th>
                                            <th>Denda</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Pengembalian as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->id_pengembalian }}</td>
                                                <td>{{ $row->peminjaman->id_peminjaman ?? 'User tidak ditemukan' }}</td>
                                                <td>{{ $row->tanggal_kembali }}</td>
                                                <td>{{ $row->tanggal_harus_kembali }}</td>
                                                <td>{{ $row->denda }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning btn-edit"
                                                        data-id="{{ $row->id_pengembalian }}"
                                                        data-peminjaman="{{ $row->peminjaman->id_peminjaman }}"
                                                        data-kembali="{{ \Carbon\Carbon::parse($row->tanggal_kembali)->format('Y-m-d') }}"
                                                        data-harus_kembali="{{ \Carbon\Carbon::parse($row->tanggal_harus_kembali)->format('Y-m-d') }}"
                                                        data-denda="{{ $row->denda }}">Edit</button>
                                                    <form action="{{ url('Pengembalian/' . $row->id_pengembalian) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
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
                                        <form class="user" action="{{ route('Pengembalian.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <select name="id_peminjaman" class="form-control rounded-pill" required>
                                                    <option value="">--- Pilih ---</option>
                                                    @foreach ($Peminjaman as $row)
                                                        <option value="{{ $row->id_peminjaman }}">{{ $row->id_peminjaman }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="date" class="form-control form-control-user"
                                                    name="tanggal_kembali" placeholder="Tanggal kembali" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="date" class="form-control form-control-user"
                                                    name="tanggal_harus_kembali" placeholder="Tanggal harus kembali"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control form-control-user" name="denda"
                                                    placeholder="Denda" required>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-info btn-user btn-block">Simpan</button>
                                            <a href="{{ route('Pengembalian.index') }}"
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
                                                    name="id_pengembalian" id="id_pengembalian"
                                                    placeholder="ID Pengembalian" readonly>
                                            </div>
                                            <div class="form-group">
                                                <select name="id_peminjaman" id="id_peminjaman" class="form-control rounded-pill" required>
                                                    <option value="">--- Pilih ---</option>
                                                    @foreach ($Peminjaman as $row)
                                                        <option value="{{ $row->id_peminjaman }}">{{ $row->id_peminjaman }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="date" class="form-control form-control-user"
                                                    name="tanggal_kembali" id="tanggal_kembali"
                                                    placeholder="Tanggal kembali" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="date" class="form-control form-control-user"
                                                    name="tanggal_harus_kembali" id="tanggal_harus_kembali"
                                                    placeholder="Tanggal harus kembali" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control form-control-user" name="denda"
                                                    id="denda" placeholder="Denda" required>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-info btn-user btn-block">Perbarui</button>
                                            <a href="{{ url('Pengembalian') }}"
                                                class="btn btn-danger btn-user btn-block">
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

    <script>
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function () {
                const form = document.getElementById('editForm');

                // Ambil data dari atribut tombol
                const id = this.dataset.id;
                const peminjaman = this.dataset.peminjaman;
                const kembali = this.dataset.kembali;
                const harus_kembali = this.dataset.harus_kembali;
                const denda = this.dataset.denda;

                // Masukkan data ke form
                form.action = `/Pengembalian/${id}`;
                document.getElementById('id_pengembalian').value = id;
                document.getElementById('id_peminjaman').value = peminjaman;
                document.getElementById('tanggal_kembali').value = kembali;
                document.getElementById('tanggal_harus_kembali').value = harus_kembali;
                document.getElementById('denda').value = denda;
            });
        });
    </script>

</body>

</html>

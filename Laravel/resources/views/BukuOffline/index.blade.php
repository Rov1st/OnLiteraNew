<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin OnLitera - Buku Offline</title>

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
                            <h6 class="m-0 font-weight-bold text-light">DataTables Buku Offline</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Buku ID</th>
                                            <th>Judul</th>
                                            <th>kategori</th>
                                            <th>Genre</th>
                                            <th>penjelasan</th>
                                            <th>Penulis</th>
                                            <th>Penerbit</th>
                                            <th>Sumber Perpustakaan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($BukuOffline as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->id_buku }}</td>
                                                <td>{{ $row->judul }}</td>
                                                <td>{{ $row->kategori }}</td>
                                                <td>{{ $row->genre }}</td>
                                                <td>{{ $row->penjelasan }}</td>
                                                <td>{{ $row->penulis }}</td>
                                                <td>{{ $row->penerbit }}</td>
                                                <td>{{ $row->sumber_perpustakaan }}</td>
                                                <td>{{ $row->status }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $row->id_buku }}"
                                                        data-judul="{{ $row->judul }}" data-kategori="{{ $row->kategori }}"
                                                        data-genre="{{ $row->genre }}"
                                                        data-penjelasan="{{ $row->penjelasan }}"
                                                        data-penulis="{{ $row->penulis }}"
                                                        data-penerbit="{{ $row->penerbit }}"
                                                        data-sumber_perpustakaan="{{ $row->sumber_perpustakaan }}"
                                                        data-status="{{ $row->status }}">Edit</button>
                                                    <form action="{{ url('BukuOffline/' . $row->id_buku) }}" method="POST"
                                                        style="display:inline;">
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
                                        <form class="user" action="{{ route('BukuOffline.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="judul"
                                                    placeholder="Judul" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    name="kategori" placeholder="Kategori" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="genre"
                                                    placeholder="Genre" required>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control form-control-user" name="penjelasan"
                                                    placeholder="Penjelasan" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="penulis"
                                                    placeholder="Penulis" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    name="penerbit" placeholder="Penerbit" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    name="sumber_perpustakaan" placeholder="Sumber_perpustakaan"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <select name="status" class="form-control rounded-pill"
                                                    required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="tersedia">Tersedia</option>
                                                    <option value="tidak tersedia">Tidak Tersedia
                                                    </option>
                                                </select>
                                            </div>

                                            <button type="submit"
                                                class="btn btn-info btn-user btn-block">Simpan</button>
                                            <a href="{{ route('BukuOffline.index') }}"
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
                                                <input type="text" class="form-control form-control-user" name="id_buku"
                                                    id="id_buku" placeholder="ID Buku" readonly>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="judul"
                                                    id="judul" placeholder="Judul" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    name="kategori" id="kategori" placeholder="Kategori" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="genre"
                                                    id="genre" placeholder="Genre" required>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control form-control-user" name="penjelasan"
                                                    id="penjelasan" placeholder="Penjelasan" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="penulis"
                                                    id="penulis" placeholder="Penulis" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="penerbit"
                                                    name="penerbit" placeholder="Penerbit" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                    id="sumber_perpustakaan" name="sumber_perpustakaan"
                                                    placeholder="Sumber_perpustakaan" required>
                                            </div>
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control rounded-pill"
                                                    required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="tersedia">Tersedia</option>
                                                    <option value="tidak tersedia">Tidak Tersedia</option>
                                                </select>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-info btn-user btn-block">Perbarui</button>
                                            <a href="{{ url('BukuOffline') }}"
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
                const judul = this.dataset.judul;
                const kategori = this.dataset.kategori;
                const genre = this.dataset.genre;
                const penjelasan = this.dataset.penjelasan;
                const penulis = this.dataset.penulis;
                const penerbit = this.dataset.penerbit;
                const sumber_perpustakaan = this.dataset.sumber_perpustakaan;
                const status = this.dataset.status;

                // Masukkan data ke form
                form.action = `/BukuOffline/${id}`;
                document.getElementById('id_buku').value = id;
                document.getElementById('judul').value = judul;
                document.getElementById('kategori').value = kategori;
                document.getElementById('genre').value = genre;
                document.getElementById('penjelasan').value = penjelasan;
                document.getElementById('penulis').value = penulis;
                document.getElementById('penerbit').value = penerbit;
                document.getElementById('sumber_perpustakaan').value = sumber_perpustakaan;
                document.getElementById('status').value = status;
            });
        });
    </script>

</body>

</html>

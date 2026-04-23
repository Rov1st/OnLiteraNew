<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin OnLitera - Detail Buku</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<body id="page-top">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


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
                            <h6 class="m-0 font-weight-bold text-light">DataTables Detail Buku</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Buku</th>
                                            <th>Genre</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($buku as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->id_buku }} - {{ $row->judul }}</td>
                                                <td>
                                                    @if($row->genres->isNotEmpty())
                                                        @foreach($row->genres as $g)
                                                            @php
                                                                $colors = [
                                                                    'Petualangan' => '#1ABC9C',
                                                                    'Komedi' => '#F39C12',
                                                                    'Romantis' => '#E84393',
                                                                    'Misteri' => '#7F8C8D', // abu gelap misterius
                                                                    'Horor' => '#2C3E50',
                                                                    'Fiksi Ilmiah' => '#8E44AD',
                                                                    'Fantasi' => '#3498DB',
                                                                ];
                                                                $color = $colors[$g->genre] ?? '#95A5A6'; // default abu2
                                                            @endphp
                                                            <span class="badge text-white" style="background-color: {{ $color }};">
                                                                {{ $g->genre }}
                                                            </span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <button class="btn btn-warning btn-sm btn-edit"
                                                        data-id_buku="{{ $row->id_buku }}"
                                                        data-genre="{{ $row->genres->pluck('genre')->implode(',') }}">
                                                        Edit
                                                    </button>
                                                    <form action="{{ url('Genre/' . $row->id_buku) }}" method="POST"
                                                        style="display:inline;">
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
                                        <form class="user" action="{{ route('Genre.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <select name="id_buku" class="form-control rounded-pill" required>
                                                    @foreach ($buku as $row)
                                                        <option value="{{ $row->id_buku }}">{{ $row->judul }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Genre</label><br>
                                                @php
                                                    $allGenres = ['Petualangan', 'Komedi', 'Romantis', 'Misteri', 'Horor', 'Fiksi Ilmiah', 'Fantasi'];
                                                @endphp
                                                @foreach ($allGenres as $g)
                                                    <label class="mr-3">
                                                        <input type="checkbox" name="genre[]" value="{{ $g }}">
                                                        {{ $g }}
                                                    </label>
                                                @endforeach
                                            </div>
                                    </div>
                                    <button type="submit" class="btn btn-info btn-user btn-block">Simpan</button>
                                    <a href="{{ route('Genre.index') }}" class="btn btn-danger btn-user btn-block">
                                        Ulang
                                    </a>
                                    </form>
                                    <hr>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-left">
                                            <h1 class="h4 text-gray-900 mb-4">Edit Data</h1>
                                        </div>
                                        <form id="editForm" class="user" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <select name="id_buku" id="id_buku_edit"
                                                    class="form-control rounded-pill" required>
                                                    @foreach ($buku as $row)
                                                        <option value="{{ $row->id_buku }}">{{ $row->judul }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Genre</label><br>
                                                @php
                                                    $allGenres = ['Petualangan', 'Komedi', 'Romantis', 'Misteri', 'Horor', 'Fiksi Ilmiah', 'Fantasi'];
                                                @endphp
                                                @foreach ($allGenres as $g)
                                                    <label class="mr-3">
                                                        <input type="checkbox" name="genre[]" value="{{ $g }}">
                                                        {{ $g }}
                                                    </label>
                                                @endforeach
                                            </div>
                                            <button type="submit"
                                                class="btn btn-warning btn-user btn-block">Update</button>
                                            <a href="{{ url('Genre') }}"
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

                const id_buku = this.dataset.id_buku;
                const genres = this.dataset.genre.split(','); // array genre

                // Set action form edit
                form.action = `/Genre/${id_buku}`;
                document.getElementById('id_buku_edit').value = id_buku;

                // Uncheck semua dulu
                document.querySelectorAll('#editForm input[name="genre[]"]').forEach(cb => {
                    cb.checked = false;
                });

                // Check sesuai genre yg dipilih
                genres.forEach(g => {
                    const checkbox = document.querySelector(`#editForm input[value="${g}"]`);
                    if (checkbox) checkbox.checked = true;
                });
            });
        });


    </script>

</body>

</html>

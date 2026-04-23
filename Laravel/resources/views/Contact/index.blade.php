<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin OnLitera - Buku Online</title>

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
                            <h6 class="m-0 font-weight-bold text-light">DataTables Contact</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Subjek</th>
                                            <th>Pesan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Contact as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->nama }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->subjek }}</td>
                                                <td>{{ $row->pesan }}</td>
                                                <td>
                                                    <form action="{{ url('Contact/' . $row->id) }}"
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
                const img = this.dataset.img;
                const url = this.dataset.url;
                const penulis = this.dataset.penulis;
                const sumber = this.dataset.sumber;

                // Masukkan data ke form
                form.action = `/Contact/${id}`;
                document.getElementById('id_buku').value = id;
                document.getElementById('judul').value = judul;
                document.getElementById('kategori').value = kategori;
                document.getElementById('genre').value = genre;
                document.getElementById('penjelasan').value = penjelasan;
                const previewImg = document.getElementById('previewImg');
                if (img) {
                    previewImg.src = `/Contactimg/${img}`;
                    previewImg.classList.remove('d-none');
                } else {
                    previewImg.classList.add('d-none');
                }
                document.getElementById('buku_url').value = url;
                document.getElementById('penulis').value = penulis;
                document.getElementById('sumber').value = sumber;
            });
        });
    </script>
    <script>
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', function (e) {
                var fileName = e.target.files[0]?.name;
                if (fileName) {
                    e.target.nextElementSibling.innerText = fileName;
                }
            });
        });

        document.getElementById('fotoEdit').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('previewImg').src = event.target.result;
                    document.getElementById('previewImg').classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        // Tambah Data - preview gambar
        document.getElementById('fotoTambah').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('previewTambah').src = event.target.result;
                    document.getElementById('previewTambah').classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

    </script>

</body>

</html>

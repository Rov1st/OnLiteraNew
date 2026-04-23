<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin OnLitera - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" data-toggle="modal" data-target="#reportModal"
                            class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                        </a>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog"
                        aria-labelledby="reportModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form id="laporanForm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pilih Periode Laporan</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="bulan">Bulan</label>
                                            <select name="bulan" id="bulan" class="form-control" required>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tahun">Tahun</label>
                                            <input type="number" id="tahun" class="form-control" value="{{ date('Y') }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-info">Download</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-bottom-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                Jumlah Anggota</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahAnggota }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-bottom-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                Jumlah Buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahBuku }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-bottom-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                Jumlah Peminjaman belum Dikonfirmasi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{$jumlahPeminjamanBelumKonfirmasi}}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Peminjaman Bulan Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanBulanIni }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Pengembalian Bulan Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengembalianBulanIni }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Total Denda Bulan Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                        {{ number_format($totalDendaBulanIni, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Earnings Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <!-- Pie Chart Status -->
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Status Peminjaman</h6>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="statusChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bar Chart Top Buku -->
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-success">Top 5 Buku Paling Dipinjam
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="topBukuChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <!-- Bar Chart Top User -->
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-warning">Top 5 User Paling Aktif
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="topUserChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
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
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/chart-area-demo.js"></script> -->
    <script src="js/demo/chart-pie-demo.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = 'Nunito, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.font.color = '#858796';
    </script>

    <script>
        window.chartData = @json($peminjamanPerBulan);
    </script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>

    <script>
        // Pie Chart Status Peminjaman
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($statusPeminjaman->keys()) !!},
                datasets: [{
                    data: {!! json_encode($statusPeminjaman->values()) !!},
                    backgroundColor: ['#1cc88a', '#e74a3b', '#36b9cc']
                }]
            }
        });

        // Bar Chart Top Buku
        const topBukuCtx = document.getElementById('topBukuChart').getContext('2d');
        new Chart(topBukuCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topBuku->pluck('buku.judul')) !!},
                datasets: [{
                    label: 'Jumlah Dipinjam',
                    data: {!! json_encode($topBuku->pluck('total')) !!},
                    backgroundColor: '#4e73df'
                }]
            }
        });

        // Bar Chart Top User
        const topUserCtx = document.getElementById('topUserChart').getContext('2d');
        new Chart(topUserCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topUser->pluck('user.name')) !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! json_encode($topUser->pluck('total')) !!},
                    backgroundColor: '#f6c23e'
                }]
            }
        });
    </script>

    <script>
        document.getElementById('laporanForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let bulan = document.getElementById('bulan').value;
            let tahun = document.getElementById('tahun').value;
            window.location.href = `/laporan-bulanan/${bulan}/${tahun}`;
        });
    </script>





</body>
<div id="notifPopup"
     style="display:none;
            position:fixed;
            bottom:20px;
            right:20px;
            background:#007bff;
            color:white;
            padding:15px;
            border-radius:8px;
            box-shadow:0px 4px 10px rgba(0,0,0,0.3);
            z-index:9999;">
</div>

</html>

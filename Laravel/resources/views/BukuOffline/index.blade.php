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

    <link href="{{ asset('css/genre.css') }}" rel="stylesheet">

    <!-- Multi-Select Dropdown Styles -->
    <style>
        .multi-select-container {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .multi-select-display {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #f8f9fc;
            border: 1px solid #d1d3e2;
            border-radius: 10rem;
            cursor: pointer;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .multi-select-display:focus {
            outline: none;
            border-color: #5a9bd4;
            box-shadow: 0 0 0 0.2rem rgba(90, 155, 212, 0.25);
        }

        .selected-genres {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            flex: 1;
        }

        .genre-tag {
            background: #1cc88a;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .genre-tag .remove {
            cursor: pointer;
            font-weight: bold;
        }

        .multi-select-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #d1d3e2;
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .genre-search {
            width: 100%;
            padding: 8px 12px;
            border: none;
            border-bottom: 1px solid #eaecf4;
            outline: none;
        }

        .genre-option {
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .genre-option:hover {
            background: #f8f9fc;
        }

        .genre-option.selected {
            background: #e3f2fd;
            color: #1976d2;
        }

        .dropdown-arrow {
            font-size: 0.8rem;
            color: #5a5c69;
            transition: transform 0.2s;
        }

        .dropdown-arrow.open {
            transform: rotate(180deg);
        }

        .placeholder-text {
            color: #6e707e;
        }

        .genre-badge{

        }


        /* Container utama */
.searchable-select-container {
  position: relative;
  width: 100%;
  font-family: inherit;
}

/* Kotak utama (mirip input genre) */
.searchable-select-display {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: .375rem .75rem;
  border: 1px solid #d1d3e2;
  border-radius: 10rem; /* sama kayak form-control-user */
  background-color: #fff;
  cursor: pointer;
  transition: border-color .2s, box-shadow .2s;
}

/* Efek focus/klik */
.searchable-select-display:focus,
.searchable-select-container.active .searchable-select-display {
  border-color: #4e73df;
  box-shadow: 0 0 0 .2rem rgba(78,115,223,.25);
  outline: none;
}

/* Placeholder / teks terpilih */
.selected-value {
  flex: 1;
  color: #6e707e;
  font-size: .9rem;
}

/* panah dropdown */
.dropdown-arrow {
  font-size: .8rem;
  margin-left: .5rem;
  color: #858796;
}

/* Menu dropdown */
.dropdown-menu-custom {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background: #fff;
  border: 1px solid #d1d3e2;
  border-radius: .5rem;
  margin-top: .25rem;
  box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
  display: none;
  z-index: 1000;
}

/* Input search */
.dropdown-menu-custom .search-input {
  width: 100%;
  border: none;
  border-bottom: 1px solid #e3e6f0;
  padding: .375rem .75rem;
  font-size: .9rem;
  border-radius: .5rem .5rem 0 0;
  outline: none;
}

/* Opsi */
.options-container {
  max-height: 180px;
  overflow-y: auto;
}

.option-item {
  padding: .5rem .75rem;
  cursor: pointer;
  transition: background-color .2s;
}

.option-item:hover {
  background-color: #f8f9fc;
  color: #4e73df;
}

/* Tampilkan dropdown */
.searchable-select-container.active .dropdown-menu-custom {
  display: block;
}

.img-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    padding-top: 60px;
    left: 0; top: 0;
    width: 100%; height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.8);
  }

  /* Gambar besar di tengah */
  .img-modal-content {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 80%;
    border-radius: 8px;
  }

  /* Tombol close */
  .img-modal-close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
  }

    </style>

</head>

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
                                            <th>Tahun Rilis</th>
                                            <th>Penerbit</th>
                                            <th>Tahun Terbit</th>
                                            <th>Stok</th>
                                            <th>Sumber Perpustakaan</th>
                                            <th>Status</th>
                                            <th>Image</th>
                                            <th>Aksi</th>
                                        </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($BukuOffline as $row)
                                            <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->id_buku }}</td>
                                            <td>{{ $row->judul }}</td>
                                            <td>{{ $row->kategori }}</td>
                                            <td>
    @forelse($row->genres as $genre)
        @php
            $slug = strtolower($genre->genre);

            // Handle spasi sebelum & agar konsisten
            $slug = str_replace(' & ', '-and-', $slug);
            $slug = str_replace('&', '-and-', $slug);

            // Handle slash
            $slug = str_replace('/', '-slash-', $slug);

            // Ganti spasi dan kurung jadi strip
            $slug = str_replace([' ', '(', ')'], '-', $slug);

            // Hapus karakter selain huruf, angka, strip
            $slug = preg_replace('/[^a-z0-9\-]+/', '-', $slug);

            // Hapus strip ganda
            $slug = preg_replace('/-+/', '-', $slug);
            $slug = trim($slug, '-');
        @endphp

        <span class="text-black badge my-1 badge-genre-{{ $slug }}">
            {{ $genre->genre }}
        </span>
    @empty
        <span class="text-muted">-</span>
    @endforelse
</td>
                                            <td title="{{ $row->penjelasan }}">
                                                {{ \Illuminate\Support\Str::limit($row->penjelasan, 50, '...') }}
                                            </td>
                                            <td>{{ $row->penulis }}</td>
                                            <td>{{ $row->tahun_rilis }}</td>
                                            <td>{{ $row->penerbit }}</td>
                                            <td>{{ $row->tahun_terbit }}</td>
                                            <td>{{ $row->stok }}</td>
                                            <td>{{ $row->sumber_perpustakaan }}</td>
                                            <td>{{ $row->status }}</td>
                                            <td>
                                            @if($row->img)
                                            <img src="{{ asset('bukuofflineimg/' . $row->img) }}" width="100">
                                            @else
                                            Tidak ada gambar
                                            @endif
                                            </td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $row->id_buku }}"
                                                        data-judul="{{ $row->judul }}" data-kategori="{{ $row->kategori }}"
                                                        data-genres='@json($row->genres->pluck("genre"))'
                                                        data-penjelasan="{{ $row->penjelasan }}"
                                                        data-penulis="{{ $row->penulis }}"
                                                        data-tahun_rilis="{{ $row->tahun_rilis }}"
                                                        data-penerbit="{{ $row->penerbit }}"
                                                        data-tahun_terbit="{{ $row->tahun_terbit }}"
                                                        data-stok="{{ $row->stok }}"
                                                        data-img="{{ $row->img }}"
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
                                        <form class="user" action="{{ route('BukuOffline.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="judul"
                                                    placeholder="Judul" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="searchable-select-container" id="kategoriSelectTambah">
                                                    <div class="searchable-select-display form-control " tabindex="0">
                                                        <div class="selected-value">
                                                            <span class="placeholder-text">Pilih kategori...</span>
                                                        </div>
                                                        <span class="dropdown-arrow">▼</span>
                                                    </div>
                                                    <div class="dropdown-menu-custom">
                                                        <input type="text" class="search-input form-control form-control-user" placeholder="Cari kategori...">
                                                        <div class="options-container"></div>
                                                    </div>
                                                    <input type="hidden" name="kategori" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="multi-select-container" id="genreSelectTambah">
                                                    <div class="multi-select-display" tabindex="0">
                                                        <div class="selected-genres">
                                                            <span class="placeholder-text">Pilih genre...</span>
                                                        </div>
                                                        <span class="dropdown-arrow">▼</span>
                                                    </div>
                                                    <div class="multi-select-dropdown">
                                                        <input type="text" class="genre-search" placeholder="Cari genre...">
                                                        <div class="genre-options">
                                                        </div>
                                                    </div>
                                                </div>
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
                                                <input type="number" class="form-control form-control-user" name="tahun_rilis" min="1900" max="2100" step="1"
                                                    placeholder="Tahun Rilis" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                name="penerbit" placeholder="Penerbit" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control form-control-user" name="tahun_terbit" min="1900" max="2100" step="1"
                                                    placeholder="Tahun Terbit" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control form-control-user"
                                                    name="stok" id="stoktambah" placeholder="Stok" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                name="sumber_perpustakaan" placeholder="Sumber Perpustakaan"
                                                required>
                                            </div>
                                            <div class="form-group">
                                                <select name="status" id="statustambah" class="form-control rounded-pill"
                                                hidden>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="tersedia">Tersedia</option>
                                                <option value="tidak tersedia">Tidak Tersedia
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                            <div class="custom-file">
                                                <img id="previewTambah" src="" alt="Preview Gambar" width="150" class="mt-5 d-none">
                                                <input type="file" class="custom-file-input" id="fotoTambah" name="img" required>
                                                <label class="custom-file-label" for="fotoTambah">Pilih gambar...</label>
                                            </div>
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
                                                <div class="searchable-select-container" id="kategoriSelectEdit">
                                                    <div class="searchable-select-display" tabindex="0">
                                                        <div class="selected-value">
                                                            <span class="placeholder-text">Pilih kategori...</span>
                                                        </div>
                                                        <span class="dropdown-arrow">▼</span>
                                                    </div>
                                                    <div class="dropdown-menu-custom">
                                                        <input type="text" class="search-input" placeholder="Cari kategori...">
                                                        <div class="options-container"></div>
                                                    </div>
                                                    <input type="hidden" name="kategori" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="multi-select-container" id="genreSelectEdit">
                                                    <div class="multi-select-display" tabindex="0">
                                                        <div class="selected-genres">
                                                            <span class="placeholder-text">Pilih genre...</span>
                                                        </div>
                                                        <span class="dropdown-arrow">▼</span>
                                                    </div>
                                                    <div class="multi-select-dropdown">
                                                        <input type="text" class="genre-search" placeholder="Cari genre...">
                                                        <div class="genre-options">
                                                            <!-- Genre options akan ditambahkan via JavaScript -->
                                                        </div>
                                                    </div>
                                                </div>
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
                                                <input type="number" class="form-control form-control-user" name="tahun_rilis" id="tahun_rilis" min="1900" max="2100" step="1"
                                                    placeholder="Tahun Rilis" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="penerbit"
                                                    name="penerbit" placeholder="Penerbit" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control form-control-user" name="tahun_terbit" id="tahun_terbit" min="1900" max="2100" step="1"
                                                    placeholder="Tahun Terbit" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control form-control-user" id="stok"
                                                    name="stok" placeholder="Stok" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user"
                                                id="sumber_perpustakaan" name="sumber_perpustakaan"
                                                placeholder="Sumber Perpustakaan" required>
                                            </div>
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control rounded-pill"
                                                hidden>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="tersedia">Tersedia</option>
                                                <option value="tidak tersedia">Tidak Tersedia</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-file">
                                        <img id="previewImg" src="" alt="Gambar Buku" width="150" class="mt-5 d-none">
                                        <input type="file" class="custom-file-input" id="fotoEdit" name="img">
                                        <label class="custom-file-label" for="fotoEdit">Pilih gambar...</label>
                                        </div>
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

    <!-- Multi-Select Genre Script -->
    <script>
    // Daftar genre manual - tidak mengambil dari database
    const GENRE_OPTIONS = [
    // Umum
    'Fiksi',
    'Non-Fiksi',

    // Fiksi / Cerita
    'Romansa',
    'Misteri',
    'Thriller',
    'Kriminal/Detektif',
    'Petualangan',
    'Fantasi',
    'Fiksi Ilmiah',
    'Distopia',
    'Horor',
    'Gotik',
    'Drama',
    'Komedi/Humor',
    'Satire/Parodi',
    'Fiksi Sejarah',
    'Realistis/Slice of Life',
    'Remaja (Young Adult)',
    'Fiksi Anak',
    'Kumpulan Cerpen',
    'Puisi',
    'Sastra Klasik',
    'Sastra Kontemporer',
    'Epik/Saga/Mitologi',
    'Cerita Rakyat/Dongeng',

    // Non-Fiksi
    'Biografi',
    'Autobiografi',
    'Memoar',
    'Sejarah',
    'Pengembangan Diri',
    'Pendidikan',
    'Agama',
    'Filsafat',
    'Psikologi',
    'Sosiologi',
    'Politik',
    'Ekonomi',
    'Bisnis & Manajemen',
    'Ilmu Pengetahuan',
    'Teknologi',
    'Kesehatan & Kedokteran',
    'Memasak/Kuliner',
    'Perjalanan/Wisata',
    'Seni',
    'Desain',
    'Fotografi',
    'Musik',
    'Olahraga',
    'Lingkungan',
    'Parenting/Keluarga',
    'Budaya&Antropologi'
    ];



    class MultiSelectGenre {
        constructor(containerId) {
            this.container = document.getElementById(containerId);
            this.display = this.container.querySelector('.multi-select-display');
            this.dropdown = this.container.querySelector('.multi-select-dropdown');
            this.searchInput = this.container.querySelector('.genre-search');
            this.genresContainer = this.container.querySelector('.selected-genres');
            this.optionsContainer = this.container.querySelector('.genre-options');
            this.arrow = this.container.querySelector('.dropdown-arrow');

            this.selectedGenres = new Set();
            this.options = [];

            this.init();
            this.createOptions();
        }

        createOptions() {
            // Buat option elements dari array genre manual
            this.optionsContainer.innerHTML = '';

            GENRE_OPTIONS.forEach(genre => {
                const optionElement = document.createElement('div');
                optionElement.className = 'genre-option';
                optionElement.dataset.value = genre;
                optionElement.innerHTML = `
                    <input type="checkbox" name="genres[]" value="${genre}" style="display: none;">
                    <span>${genre}</span>
                `;

                optionElement.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleOption(optionElement);
                });

                this.optionsContainer.appendChild(optionElement);
            });

            this.options = this.container.querySelectorAll('.genre-option');
        }

        init() {
            // Toggle dropdown
            this.display.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleDropdown();
            });

            // Search functionality
            this.searchInput.addEventListener('input', (e) => {
                this.filterOptions(e.target.value);
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!this.container.contains(e.target)) {
                    this.closeDropdown();
                }
            });

            // Keyboard navigation
            this.display.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.toggleDropdown();
                }
            });
        }

        toggleDropdown() {
            const isOpen = this.dropdown.style.display === 'block';
            if (isOpen) {
                this.closeDropdown();
            } else {
                this.openDropdown();
            }
        }

        openDropdown() {
            this.dropdown.style.display = 'block';
            this.arrow.classList.add('open');
            this.searchInput.focus();
        }

        closeDropdown() {
            this.dropdown.style.display = 'none';
            this.arrow.classList.remove('open');
            this.searchInput.value = '';
            this.filterOptions('');
        }

        filterOptions(searchTerm) {
            const term = searchTerm.toLowerCase();
            this.options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(term) ? 'flex' : 'none';
            });
        }

        toggleOption(option) {
            const value = option.dataset.value;
            const checkbox = option.querySelector('input[type="checkbox"]');

            if (this.selectedGenres.has(value)) {
                this.selectedGenres.delete(value);
                option.classList.remove('selected');
                checkbox.checked = false;
            } else {
                this.selectedGenres.add(value);
                option.classList.add('selected');
                checkbox.checked = true;
            }

            this.updateDisplay();
        }

        updateDisplay() {
            const placeholder = this.genresContainer.querySelector('.placeholder-text');

            if (this.selectedGenres.size === 0) {
                this.genresContainer.innerHTML = '<span class="placeholder-text">Pilih genre...</span>';
            } else {
                this.genresContainer.innerHTML = '';
                this.selectedGenres.forEach(genre => {
                    const tag = document.createElement('span');
                    tag.className = 'genre-tag';
                    tag.innerHTML = `${genre} <span class="remove">&times;</span>`;

                    tag.querySelector('.remove').addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.removeGenre(genre);
                    });

                    this.genresContainer.appendChild(tag);
                });
            }
        }

        removeGenre(genre) {
            const option = this.container.querySelector(`.genre-option[data-value="${genre}"]`);
            if (option) {
                this.toggleOption(option);
            }
        }

        setSelectedGenres(genres) {
            // Clear current selection
            this.selectedGenres.clear();
            this.options.forEach(option => {
                option.classList.remove('selected');
                option.querySelector('input[type="checkbox"]').checked = false;
            });

            // Set new selection
            genres.forEach(genre => {
                const option = this.container.querySelector(`.genre-option[data-value="${genre}"]`);
                if (option) {
                    this.selectedGenres.add(genre);
                    option.classList.add('selected');
                    option.querySelector('input[type="checkbox"]').checked = true;
                }
            });

            this.updateDisplay();
        }
    }

    // Initialize multi-select dropdowns
    const genreSelectTambah = new MultiSelectGenre('genreSelectTambah');
    const genreSelectEdit = new MultiSelectGenre('genreSelectEdit');

    const KATEGORI_OPTIONS = [
    // Fiksi
    'Novel',
    'Komik',
    'Cerpen',
    'Puisi',
    'Drama',
    'Fantasi',
    'Fiksi Ilmiah (Sci-Fi)',
    'Misteri / Thriller',
    'Romansa',
    'Horor',
    'Petualangan',
    'Fiksi Remaja (Young Adult)',
    'Fiksi Anak',

    // Non-Fiksi Umum
    'Biografi',
    'Autobiografi',
    'Sejarah',
    'Agama',
    'Filsafat',
    'Psikologi',
    'Sosiologi',
    'Antropologi',
    'Politik',
    'Hukum',
    'Ekonomi',
    'Bisnis & Manajemen',
    'Pendidikan',
    'Teknologi',
    'Sains',
    'Kesehatan & Kedokteran',
    'Lingkungan',
    'Pertanian',
    'Geografi',
    'Arsitektur',
    'Seni & Desain',
    'Musik',
    'Fotografi',
    'Bahasa & Linguistik',
    'Matematika',
    'Komputer & Informatika',

    // Panduan / Praktis
    'Kamus & Ensiklopedia',
    'Panduan Belajar',
    'Buku Pelajaran',
    'Buku Referensi',
    'Buku Masak / Kuliner',
    'Hobi & Kerajinan',
    'Olahraga',
    'Travel / Wisata',
    'Pengembangan Diri',
    'Motivasi',
    'Parenting',
    'Keterampilan Hidup',

    // Anak & Edukasi
    'Dongeng',
    'Cerita Bergambar',
    'Board Book',
    'Edukasi Anak',
    'Aktivitas Anak',

    // Lain-lain
    'Jurnal',
    'Majalah',
    'Karya Ilmiah',
    'Kumpulan Artikel',
    'Esai'
    ];


class SearchableSingleSelect {
            constructor(containerId, options) {
                this.container = document.getElementById(containerId);
                if (!this.container) {
                    console.error(`Container with id '${containerId}' not found`);
                    return;
                }

                this.display = this.container.querySelector('.searchable-select-display');
                this.dropdown = this.container.querySelector('.dropdown-menu-custom');
                this.searchInput = this.container.querySelector('.search-input');
                this.valueContainer = this.container.querySelector('.selected-value');
                this.optionsContainer = this.container.querySelector('.options-container');
                this.hiddenInput = this.container.querySelector('input[type="hidden"]');
                this.arrow = this.container.querySelector('.dropdown-arrow');

                this.options = options;
                this.selectedValue = '';

                this.init();
                this.createOptions();
            }

            createOptions() {
                this.optionsContainer.innerHTML = '';

                this.options.forEach(option => {
                    const optionElement = document.createElement('div');
                    optionElement.className = 'option-item';
                    optionElement.dataset.value = option;
                    optionElement.innerHTML = `<span>${option}</span>`;

                    optionElement.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.selectOption(option);
                    });

                    this.optionsContainer.appendChild(optionElement);
                });

                this.optionElements = this.container.querySelectorAll('.option-item');
            }

            init() {
                // Toggle dropdown
                this.display.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.toggleDropdown();
                });

                // Search functionality
                this.searchInput.addEventListener('input', (e) => {
                    this.filterOptions(e.target.value);
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', (e) => {
                    if (!this.container.contains(e.target)) {
                        this.closeDropdown();
                    }
                });

                // Keyboard navigation
                this.display.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.toggleDropdown();
                    }
                });
            }

            toggleDropdown() {
                const isOpen = this.dropdown.style.display === 'block';
                if (isOpen) {
                    this.closeDropdown();
                } else {
                    this.openDropdown();
                }
            }

            openDropdown() {
                this.dropdown.style.display = 'block';
                this.arrow.classList.add('open');
                this.searchInput.focus();
            }

            closeDropdown() {
                this.dropdown.style.display = 'none';
                this.arrow.classList.remove('open');
                this.searchInput.value = '';
                this.filterOptions('');
            }

            filterOptions(searchTerm) {
                const term = searchTerm.toLowerCase();
                this.optionElements.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(term) ? 'flex' : 'none';
                });
            }

            selectOption(value) {
                this.selectedValue = value;
                this.hiddenInput.value = value;
                this.updateDisplay();
                this.closeDropdown();
                this.updateDebugInfo();
            }

            updateDisplay() {
                if (this.selectedValue) {
                    this.valueContainer.innerHTML = `<span style="color: #5a5c69;">${this.selectedValue}</span>`;
                } else {
                    this.valueContainer.innerHTML = '<span class="placeholder-text">Pilih kategori...</span>';
                }

                // Update selected state
                this.optionElements.forEach(option => {
                    if (option.dataset.value === this.selectedValue) {
                        option.classList.add('selected');
                    } else {
                        option.classList.remove('selected');
                    }
                });
            }

            setSelectedValue(value) {
                if (this.options.includes(value)) {
                    this.selectOption(value);
                }
            }

            getSelectedValue() {
                return this.selectedValue;
            }

            updateDebugInfo() {
                // Update debug info if elements exist
                const debugElement = document.getElementById(`debugKategori${this.container.id.includes('Edit') ? 'Edit' : 'Tambah'}`);
                if (debugElement) {
                    debugElement.textContent = this.selectedValue || '-';
                }
            }
        }

        const kategoriSelectTambah = new SearchableSingleSelect('kategoriSelectTambah', KATEGORI_OPTIONS);
const kategoriSelectEdit = new SearchableSingleSelect('kategoriSelectEdit', KATEGORI_OPTIONS);


    // Edit button functionality
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            const form = document.getElementById('editForm');

            // ambil data dari tombol
            const id = this.dataset.id;
            const judul = this.dataset.judul;
            const kategori = this.dataset.kategori;
            const genres = JSON.parse(this.dataset.genres || '[]');
            const penjelasan = this.dataset.penjelasan;
            const penulis = this.dataset.penulis;
            const tahun_rilis = this.dataset.tahun_rilis;
            const penerbit = this.dataset.penerbit;
            const tahun_terbit= this.dataset.tahun_terbit;
            const img = this.dataset.img;
            const stok = this.dataset.stok;
            const sumber_perpustakaan = this.dataset.sumber_perpustakaan;
            const status = this.dataset.status;

            // isi form input
            form.action = `/BukuOffline/${id}`;
            document.getElementById('id_buku').value = id;
            document.getElementById('judul').value = judul;
            kategoriSelectEdit.setSelectedValue(kategori);
            document.getElementById('penjelasan').value = penjelasan;
            document.getElementById('penulis').value = penulis;
            document.getElementById('tahun_rilis').value = tahun_rilis;
            document.getElementById('penerbit').value = penerbit;
            document.getElementById('tahun_terbit').value = tahun_terbit;
            document.getElementById('stok').value = stok;
            document.getElementById('sumber_perpustakaan').value = sumber_perpustakaan;
            document.getElementById('status').value = status;

            // preview gambar
            const previewImg = document.getElementById('previewImg');
            if (img) {
                previewImg.src = `/bukuofflineimg/${img}`;
                previewImg.classList.remove('d-none');
            } else {
                previewImg.classList.add('d-none');
            }

            // Set selected genres for edit form
            genreSelectEdit.setSelectedGenres(genres);
        });
    });
    </script>

    <script>
      document.querySelectorAll('.custom-file-input').forEach(input => {
      input.addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name;
        if (fileName) {
          e.target.nextElementSibling.innerText = fileName;
        }
      });
    });

      document.getElementById('fotoEdit').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          document.getElementById('previewImg').src = event.target.result;
          document.getElementById('previewImg').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
      }
    });

    // Tambah Data - preview gambar
    document.getElementById('fotoTambah').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          document.getElementById('previewTambah').src = event.target.result;
          document.getElementById('previewTambah').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
      }
    });



    function bindAutoStatus(stokId, statusId) {
    const stokInput = document.getElementById(stokId);
    const statusSelect = document.getElementById(statusId);
    if (!stokInput || !statusSelect) return;

    const update = () => {
      const val = parseInt(stokInput.value, 10) || 0;
      statusSelect.value = val > 0 ? 'tersedia' : 'tidak tersedia';
    };

    // jalankan saat user mengetik
    stokInput.addEventListener('input', update);

    // jalankan sekali untuk inisialisasi jika ada nilai awal
    update();
  }
  bindAutoStatus('stoktambah', 'statustambah');
  bindAutoStatus('stok', 'status');
    </script>

</body>

</html>

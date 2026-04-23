<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <audio id="notifSound" preload="auto">
            <source src="/sounds/notif1.mp3" type="audio/mpeg">
        </audio>

            <a class="nav-link dropdown-toggle" href="{{ route('DetailPeminjaman.index', ['status' => 'Menunggu Konfirmasi']) }}" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">{{$jumlahPinjamBelumKonfirmasi}}</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown" id="notifDropdown">
                <h6 class="dropdown-header">
                    Message Center
                </h6>
                <div id="notifItems">
        @foreach ($pinjamBelumKonfirmasi as $pinjam)
            <a class="dropdown-item d-flex align-items-center" href="/DetailPeminjaman">
                <div class="font-weight-bold">
                    <div>
                        {{ $pinjam->user->display_name }} mengajukan pinjaman pada:<br> {{ $pinjam->tanggal_pinjam }}
                    </div>
                    <div class="small text-gray-500">
                        Status: {{ $pinjam->status }}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
</div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->display_name;}}</span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                {{-- <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a> --}}
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
            </form>
        </div>
    </div>
</div>
</div>

<script>
let lastCount = 0;
let notifSound = document.getElementById('notifSound');
let notifPopup = document.getElementById('notifPopup');

// Izinkan audio play setelah user klik halaman
document.body.addEventListener("click", function() {
    notifSound.play().then(() => {
        notifSound.pause();
        notifSound.currentTime = 0;
    });
}, { once: true });

function showPopup(message) {
    notifPopup.innerText = message;
    notifPopup.style.display = "block";

    // Hilangkan popup setelah 4 detik
    setTimeout(() => {
        notifPopup.style.display = "none";
    }, 4000);
}

function loadNotif() {
    fetch('/notif/unread-data')
        .then(response => response.json())
        .then(data => {
            // Update badge angka
            document.querySelector('.badge-counter').innerText = data.count;

            // Jika ada request baru
            if (data.count > lastCount) {
                notifSound.play().catch(err => console.log("Sound blocked:", err));
                showPopup("📚 Ada peminjaman baru menunggu konfirmasi!");
            }
            lastCount = data.count;

            // Update isi notif dropdown
            let notifItems = document.getElementById('notifItems');
            if (data.list.length === 0) {
                notifItems.innerHTML = `
                    <div class="dropdown-item text-center small text-gray-500">
                        Tidak ada peminjaman baru
                    </div>
                `;
            } else {
                let html = '';
                data.list.forEach(pinjam => {
                    html += `
                        <a class="dropdown-item d-flex align-items-center" href="/DetailPeminjaman">
                            <div class="font-weight-bold">
                                <div>
                                    ${pinjam.user.display_name} mengajukan pinjaman pada:<br> ${pinjam.tanggal_pinjam}
                                </div>
                                <div class="small text-gray-500">
                                    Status: ${pinjam.status}
                                </div>
                            </div>
                        </a>
                    `;
                });
                notifItems.innerHTML = html;
            }
        })
        .catch(err => console.error('Error load notif:', err));
}

// Jalankan pertama kali
loadNotif();

// Refresh tiap 5 detik
setInterval(loadNotif, 5000);
</script>

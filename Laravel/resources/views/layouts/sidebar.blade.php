<!-- Style Fixed Sidebar & Topbar -->
<style>
    /* Sidebar Fixed */
    #accordionSidebar {
        position: fixed !important;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
    }

    /* Topbar Fixed */
    .topbar {
        position: fixed !important;
        top: 0;
        left: 224px;
        right: 0;
        z-index: 999;
    }

    /* Content Wrapper */
    #content-wrapper {
        margin-left: 224px;
        padding-top: 70px;
    }

    /* Saat sidebar di-collapse */
    body.sidebar-toggled #accordionSidebar {
        width: 104px;
    }

    body.sidebar-toggled .topbar {
        left: 104px;
    }

    body.sidebar-toggled #content-wrapper {
        margin-left: 104px;
    }

    /* Responsive: Mobile */
    @media (max-width: 768px) {
        #accordionSidebar {
            position: fixed !important;
            left: -224px;
        }

        .topbar {
            left: 0 !important;
        }

        #content-wrapper {
            margin-left: 0 !important;
            padding-top: 70px;
        }

        body.sidebar-toggled #accordionSidebar {
            left: 0;
        }
    }
</style>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin OnLitera</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Table List:</h6>
                <a class="collapse-item" href="{{ url('BukuOffline') }}">Buku Offline</a>
                <a class="collapse-item" href="{{ url('DetailBuku') }}">Detail Buku</a>
                <a class="collapse-item" href="{{ url('Peminjaman') }}">Peminjaman</a>
                <a class="collapse-item" href="{{ url('Pengembalian') }}">Pengembalian</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('DetailPeminjaman') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Peminjaman Offline</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('BukuOffline') }}">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Tambah Buku</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('Contact') }}">
            <i class="fas fa-fw fa-phone"></i>
            <span>Contact</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

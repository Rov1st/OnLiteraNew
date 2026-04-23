<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Peminjaman;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.topbar', function ($view) {
            $pinjamBelumKonfirmasi = Peminjaman::where('status', 'Menunggu Konfirmasi')
                ->with('user')
                ->get();
            $jumlahPinjamBelumKonfirmasi = Peminjaman::where('status', 'Menunggu Konfirmasi')->count();

            $view->with([
                'pinjamBelumKonfirmasi' => $pinjamBelumKonfirmasi,
                'jumlahPinjamBelumKonfirmasi' => $jumlahPinjamBelumKonfirmasi
            ]);
        });
    }
}

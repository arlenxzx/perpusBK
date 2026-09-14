@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-4">

        <div class="col-4">
            <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <p class="text-muted mb-1">Total</p>
                            <h1 class="fw-bold mb-0">{{ $buku }}</h1>
                        </div>

                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                            <i class="bi bi-book fs-3"></i>
                        </div>
                    </div>

                    <h5 class="fw-semibold mb-1">Buku</h5>
                    <p class="text-muted small mb-4">
                        Jumlah buku yang tersedia
                    </p>

                    <a href="/buku" class="btn btn-primary w-100 rounded-3">
                        <i class="bi bi-arrow-right me-2"></i>
                        Cek Buku
                    </a>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <p class="text-muted mb-1">Total</p>
                            <h1 class="fw-bold mb-0">{{ $user }}</h1>
                        </div>

                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                            <i class="bi bi-person-fill fs-3"></i>
                        </div>
                    </div>

                    <h5 class="fw-semibold mb-1">User</h5>
                    <p class="text-muted small mb-4">
                        Jumlah user yang terdaftar
                    </p>

                    <a href="/user" class="btn btn-warning w-100 rounded-3">
                        <i class="bi bi-arrow-right me-2"></i>
                        Cek User
                    </a>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <p class="text-muted mb-1">Total</p>
                            <h1 class="fw-bold mb-0">{{ $transaksi }}</h1>
                        </div>

                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                            <i class="bi bi-book fs-3"></i>
                        </div>
                    </div>

                    <h5 class="fw-semibold mb-1">Transaksi</h5>
                    <p class="text-muted small mb-4">
                        Jumlah transaksi yang tercatat
                    </p>

                    <a href="/transaksi" class="btn btn-success w-100 rounded-3">
                        <i class="bi bi-arrow-right me-2"></i>
                        Cek Transaksi
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
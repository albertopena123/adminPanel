@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">AI</li>
        </ul>
    </div>




    <!-- Admin Specific Section -->
    @if (Auth::user()->hasRole('admin'))
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border bg-gradient-start-1">
                    <div class="card-body p-20">
                        <h6 class="fw-semibold mb-3 text-primary-light">Acciones de Administrador</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="d-flex align-items-center gap-2 hover-text-primary">
                                    <iconify-icon icon="solar:settings-bold" class="text-primary-light"></iconify-icon>
                                    Panel de Administración
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                    class="d-flex align-items-center gap-2 hover-text-primary">
                                    <iconify-icon icon="solar:users-group-rounded-bold"
                                        class="text-primary-light"></iconify-icon>
                                    Gestionar Usuarios
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- User Roles Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border">
                <div class="card-body p-20">
                    <h6 class="fw-semibold mb-3">Tus roles:</h6>
                    <ul class="list-unstyled">
                        @foreach (Auth::user()->roles as $role)
                            <li class="d-flex align-items-center gap-2 mb-2">
                                <iconify-icon icon="solar:shield-user-bold" class="text-primary-light"></iconify-icon>
                                {{ $role->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

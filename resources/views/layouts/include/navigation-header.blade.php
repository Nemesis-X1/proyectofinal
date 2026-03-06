<?php

use App\Models\Empresa;

$empresa = Empresa::first();
?>
<nav class="sb-topnav navbar navbar-expand navbar-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{ route('panel') }}">{{$empresa->nombre ?? ''}}</a>
    <!-- Sidebar Toggle (Hamburguesa) -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-3" id="sidebarToggle" href="#!"
        style="color: #3c4858; font-size: 1.1rem; padding: 6px 10px; border-radius: 8px; transition: all 0.3s;"
        title="Ocultar/Mostrar menú">
        <i class="fas fa-bars" style="transition: transform 0.3s ease;"></i>
    </button>
    
    <!-- Ms-auto para empujar los elementos a la derecha -->
    <div class="ms-auto d-flex align-items-center" style="margin-right: 2rem;">
        
        <!-- Modo Oscuro Premium Pill -->
        <div class="theme-switch-wrapper me-3">
            <div class="theme-switch-container" id="theme-pill-toggle">
                <div class="theme-switch-content">
                    <span class="theme-switch-text text-day">MODO DÍA</span>
                    <span class="theme-switch-text text-night">MODO NOCHE</span>
                </div>
                <div class="theme-switch-knob">
                    <i class="fas fa-sun icon-sun"></i>
                    <i class="fas fa-moon icon-moon"></i>
                </div>
            </div>
        </div>

        <!-- Notificaciones -->
        <div class="nav-item dropdown ms-2 me-2">
            <a class="nav-link dropdown-toggle position-relative" id="notificationsDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #642582;">
                <i class="fas fa-bell fa-fw"></i>
                @if (auth()->user()->unreadNotifications->count() > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; padding: 0.25em 0.5em;">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="min-width: 300px; max-height: 400px; overflow-y: auto; border: none; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); border-radius: 12px;">
                <li class="dropdown-header fw-bold text-dark px-3 py-2 border-bottom">Notificaciones</li>
                @forelse (auth()->user()->unreadNotifications as $notification)
                <li>
                    <a class="dropdown-item px-3 py-3 border-bottom" href="{{ $notification->data['url'] ?? '#' }}" style="white-space: normal; transition: background 0.2s;">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <span class="badge bg-primary-soft text-primary p-2" style="background-color: rgba(100, 37, 130, 0.1); color: #642582 !important;">
                                    <i class="fas {{ $notification->data['icon'] ?? 'fa-info-circle' }}"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 small fw-semibold text-dark">{{ $notification->data['message'] ?? 'Nueva notificación' }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                @empty
                <li class="px-3 py-4 text-center text-muted">
                    <i class="fas fa-bell-slash d-block mb-2 style-opacity: 0.5;"></i>
                    <p class="mb-0 small">No tienes notificaciones pendientes</p>
                </li>
                @endforelse
            </ul>
        </div>

        <!-- Usuario -->
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #642582;">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                @can('ver-perfil')
                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Configuraciones</a></li>
                @endcan
                @can('ver-registro-actividad')
                <li><a class="dropdown-item" href="{{ route('activityLog.index') }}">Registro de actividad</a></li>
                @endcan
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('theme-pill-toggle');
        
        // Cargar estado inicial
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);

        themeToggle.addEventListener('click', function() {
            let activeTheme = document.documentElement.getAttribute('data-theme');
            let newTheme = activeTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    });
</script>
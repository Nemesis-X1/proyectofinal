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

        <!-- Usuario -->
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #666;">
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
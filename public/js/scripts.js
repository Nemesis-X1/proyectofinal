/*!
    * Start Bootstrap - SB Admin v7.0.5 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2022 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
window.addEventListener('DOMContentLoaded', event => {

    // Restaurar estado del sidebar al recargar
    if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        document.body.classList.add('sb-sidenav-toggled');
    }

    // Toggle del sidebar con el botón hamburguesa
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));

            // Animación del icono hamburguesa
            const icon = sidebarToggle.querySelector('i');
            if (icon) {
                const isToggled = document.body.classList.contains('sb-sidenav-toggled');
                icon.style.transform = isToggled ? 'rotate(90deg)' : 'rotate(0deg)';
            }
        });
    }

});

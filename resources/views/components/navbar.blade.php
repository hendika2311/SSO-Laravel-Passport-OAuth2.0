<nav class="navbar">
    <a href="{{ url('/') }}" class="nav-logo">Client</a>
    
    <div class="nav-menu" id="navMenu">
        <a href="{{ url('/') }}" class="nav-item {{ Request::is('/') ? 'active' : '' }}">Beranda</a>
        <a href="{{ url('/layanan') }}" class="nav-item {{ Request::is('layanan') ? 'active' : '' }}">Layanan</a>
        <a href="{{ url('/tentang') }}" class="nav-item {{ Request::is('tentang') ? 'active' : '' }}">Tentang Kami</a>
        
        <a href="{{ url('/logout') }}" class="nav-item nav-button">LogOut</a>
    </div>
    
    <button class="menu-toggle" aria-label="Toggle Navigation" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>
</nav>
<header class="body__header">
    <!-- Logo -->
    <div class="header__div_logo">
        INSTACLONE
    </div>
    <!-- Enlaces de navegación para usuarios autenticados -->
    <nav class="header__navigation">
        <a href="{{ route('posts.home') }}" class="navigation__a">
            <i class="fas fa-home"></i> Home
        </a>
        <a href="{{ route('posts.form') }}" class="navigation__a">
            <i class="fas fa-plus-circle"></i> Crear Post
        </a>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}" class="navigation__a">
            <i class="fas fa-user"></i> Perfil
        </a>
        <a href="{{ route('user.logout') }}" class="navigation__a">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</header>

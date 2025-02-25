        <a href="{{ route('user.show', ['id'=>$user->id]) }}" class="navigation__a">
            PERFIL
        </a>
        <a href="{{ route('user.logout', ['id'=>$user->id]) }}" class="navigation__a">
            LOGOUT
        </a>
    </nav>
</header>
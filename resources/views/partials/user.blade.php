@vite('resources/css/user_styles/perfil_styles.css')
<main class="main__perfil">
    <div class="user-info">

        <h2>Información del Usuario</h2>
        <p><strong>Nombre:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Fecha de Registro:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
    </div>
</main>
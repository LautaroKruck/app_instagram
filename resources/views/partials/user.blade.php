@vite('resources/css/user_styles/perfil_styles.css')

<main class="main__perfil">
    <div class="user-info">
        <!-- Imagen de perfil (Opcional) -->
        <img class="user-avatar" src="URL_DE_LA_IMAGEN" alt="Avatar del usuario">

        <h2>Información del Usuario</h2>
        <p><strong>Nombre:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Fecha de Registro:</strong> {{ $user->created_at->format('d/m/Y') }}</p>

        <!-- Contenedor de botones -->
        <div class="user-actions">
            <button class="edit-btn">✏️ Editar Perfil ✏️</button>
            <button class="delete-btn">❌ Eliminar Cuenta ❌</button>
        </div>
    </div>
</main>

@vite('resources/css/user_styles/perfil_styles.css')

<main class="main__perfil">
    <div class="user-info">
        <!-- Imagen de perfil -->
        <div class="user-avatar-container">
            <img class="user-avatar" src="URL_DE_LA_IMAGEN" alt="Avatar del usuario">
        </div>

        <!-- Información del usuario -->
        <div class="user-details">
            <h2>Información del Usuario</h2>
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Fecha de Registro:</strong> {{ $user->created_at->format('d/m/Y') }}</p>

            <!-- Contenedor de botones -->
            <div class="user-actions">
                <button class="edit-btn">Editar Perfil</button>
                <button class="delete-btn">Eliminar Cuenta</button>
            </div>
        </div>
    </div>

    <!-- Sección de Posts -->
    <section class="user-posts">
        <h3>Mis Publicaciones</h3>
        <div class="posts-grid">
            @foreach($user->posts as $post)
                <article class="post-card">
                    <h4>{{ $post->title }}</h4>
                    <p>{{ Str::limit($post->description, 100) }}</p>
                    <img class="post-image" src="{{ $post->image_url }}" alt="Imagen del post">
                    <p><strong>Likes:</strong> {{ $post->n_likes }}</p>
                    <button class="comment-btn">Comentarios</button>
                    <button class="delete-post-btn">Eliminar</button>
                </article>
            @endforeach
        </div>
    </section>
</main>

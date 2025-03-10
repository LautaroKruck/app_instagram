@vite('resources/css/user_styles/perfil_styles.css')

<main class="main__perfil">
    <div class="user-info">
        <!-- Imagen de perfil -->
        <div class="user-avatar-container">
            <img class="user-avatar" 
                src="{{ asset('storage/' . ($user->image ? $user->image : 'profiles/default-avatar.jpg')) }}" 
                alt="Avatar del usuario">
        </div>


        <!-- Información del usuario -->
        <div class="user-details">
            <h2>Información del Usuario</h2>
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Fecha de Registro:</strong> {{ $user->created_at->format('d/m/Y') }}</p>

            <!-- Contenedor de botones -->
            <div class="user-actions">
                <form action="{{ route('user.image', ['id' => $user->id]) }}" method="PUT" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="image">
                    <button type="submit" class="edit-btn">Agregar Foto</button>
                </form>

                <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">Eliminar Cuenta</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sección de Posts -->
    @if($user->posts->count() > 0)
        <section class="user-posts">
            <h3>Mis Publicaciones</h3>
            <div class="posts-grid">
                @foreach($user->posts as $post)
                    <article class="post-card">
                        <h4>{{ $post->title }}</h4>
                        <p>{{ Str::limit($post->description, 100) }}</p>
                        <div class="post-picture-display">
                            <img src="{{ asset('storage/' . $post-> image) }}" class="post-picture">
                        </div>
                        <p><strong>Likes:</strong> {{ $post->n_likes }}</p>
                        <form action="{{ route('posts.delete', ['id' => $post->id]) }}" method="POST">
                            @csrf
                            @method('DELETE') 
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>

                    </article>
                @endforeach
            </div>
        </section>
    @endif
</main>

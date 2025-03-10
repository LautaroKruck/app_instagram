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

            <!-- Contenedor de acciones de usuario -->
                <div class="user-actions">
                    <!-- Caja contenedora para los botones -->
                    <div class="buttons-container">
                        <!-- Formulario para agregar imagen -->
                        <form action="{{ route('user.image', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Input para subir archivo -->
                            <input type="file" name="image" accept="image/*" class="input-image">
                            
                            <!-- Mostrar errores si no se selecciona un archivo -->
                            @if ($errors->has('image'))
                                <small class="error-message">{{ $errors->first('image') }}</small>
                            @endif
                            
                            <button type="submit" class="edit-btn">Agregar Foto</button>
                        </form>

                        <!-- Formulario para eliminar cuenta -->
                        <form action="{{ route('user.delete') }}" method="POST">
                            @csrf
                            @method('DELETE') <!-- Indicamos que es un método DELETE -->
                            <button type="submit" class="delete-btn">Eliminar Cuenta</button>
                        </form>
                    </div>
                </div>
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

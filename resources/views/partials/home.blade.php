<main class="main__home">
    <h1>Welcome, {{ Auth::user()->name }}</h1>

    <section class="posts">
        @foreach($posts as $post)
            <article class="post">
                <h2>{{ $post->title }}</h2>
                <p><small>Posted by {{ $post->user->name }} on {{ optional($post->created_at)->format('M d, Y') }}</small></p>
                
                <!-- Imagen del post -->
                <div class="post-picture-display">
                    <img src="{{ asset('storage/' . $post-> image) }}" class="post-picture">
                </div>

                <p>{{ $post->description }}</p>
                
                <!-- Botón de like con formulario -->
                <div class="like-button">
                    <form action="{{ route('posts.like') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button class="like-btn" type="submit">❤️ Like ❤️</button>
                    </form>
                    <span class="like-count">{{ $post->n_likes }}</span>
                </div>

                <!-- Botón para desplegar comentarios -->
                <button onclick="toggleComments('{{ $post->id }}')">💬 Comentarios</button>

                <!-- Sección de comentarios oculta por defecto -->
                <!-- Sección de comentarios oculta por defecto -->
                <div id="comments-{{ $post->id }}" style="display: none;">
                    <h4>Comentarios:</h4>
                    @foreach($post->comments as $comment)
                        <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                    @endforeach

                    <!-- Formulario para añadir comentario -->
                    <form action="{{ route('comments.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <textarea name="content" rows="2" placeholder="Añade un comentario..." required></textarea>
                        <button type="submit">Comentar</button>
                    </form>
                </div>
            </article>
        @endforeach
    </section>
</main>
<main class="main__home">
    <h1>Welcome, {{ Auth::user()->name }}</h1>

    <section class="posts">
        @foreach($posts as $post)
            <article class="post">
                <h2>{{ $post->title }}</h2>
                <p><small>Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</small></p>
                
                <!-- Imagen del post -->
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post image">
                @endif

                <p>{{ $post->content }}</p>
                
                <!-- Botón de like -->
                <div class="like-button">
                    <button class="like-btn" onclick="likePost({{ $post->id }})">❤️ Like</button>
                    <span id="like-count-{{ $post->id }}" class="like-count">{{ $post->likes_count }}</span>
                </div>

                <!-- Botón para desplegar comentarios -->
                <button onclick="toggleComments('{{ $post->id }}')">💬 Comentarios</button>

                <!-- Sección de comentarios oculta por defecto -->
                <div id="comments-{{ $post->id }}" style="display: none;">
                    @foreach($post->comments as $comment)
                        <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                    @endforeach
                </div>
            </article>
        @endforeach
    </section>
</main>

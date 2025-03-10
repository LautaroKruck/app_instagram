@vite('resources/css/posts_styles/home_styles.css')

<main class="main__home">
    <div class="content__home">
        <h1>Welcome, {{ Auth::user()->name }}</h1>

        <section class="posts">
            @foreach($posts as $post)
                <article class="post">
                    <h2>{{ $post->title }}</h2>
                    <p class="post-meta">📅 {{ optional($post->created_at)->format('M d, Y') }} | ✍️ {{ $post->user->name }}</p>

                    <!-- Imagen del post -->
                    @if($post->image)
                        <div class="post-picture-container">
                            <img src="{{ asset('storage/' . $post->image) }}" class="post-picture">
                        </div>
                    @endif

                    <p class="post-description">{{ $post->description }}</p>
                    
                    <!-- Botón de like con contador -->
                    <div class="like-container">
                        <form action="{{ route('posts.like') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button class="like-btn" type="submit">❤️ Like</button>
                        </form>
                        <span class="like-count">{{ $post->n_likes }} Likes</span>
                    </div>

                    <!-- Botón para ver comentarios -->
                    <button class="comment-toggle" onclick="toggleComments('{{ $post->id }}')">💬 Comentarios</button>

                    <!-- Sección de comentarios -->
                    <div id="comments-{{ $post->id }}" class="comments-section" style="display: none;">
                        <h4>Comentarios</h4>
                        @foreach($post->comments as $comment)
                            <p class="comment"><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
                        @endforeach

                        <!-- Formulario de comentario -->
                        <form action="{{ route('comments.create') }}" method="POST" class="comment-form">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <textarea name="content" rows="2" placeholder="Añade un comentario..." required></textarea>
                            <button type="submit" class="comment-submit">Comentar</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </section>
    </div>
</main>
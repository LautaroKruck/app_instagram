<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @include('partials.include-styles')
    <script>
        function toggleComments(postId) {
            let commentsSection = document.getElementById('comments-' + postId);
            commentsSection.style.display = commentsSection.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('profile') }}">Profile</a></li>
                <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Welcome, {{ Auth::user()->name }}</h1>

        <section class="posts">
            @foreach($posts as $post)
                <article class="post">
                    <h2>{{ $post->title }}</h2>
                    <p><small>Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</small></p>
                    
                    <!-- Imagen del post -->
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" style="width: 100%; max-height: 400px; object-fit: cover;">
                    @endif

                    <p>{{ $post->content }}</p>

                    <!-- Botón de like (checkbox) -->
                    <label>
                        <input type="checkbox" name="like"> ❤️ Like
                    </label>

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

    <footer>
        <p>&copy; 2023 Instagram Clone</p>
    </footer>
</body>
</html>
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
        function likePost(postId) {
            // Llamada a la API o a una ruta que incremente los likes en el servidor
            fetch(`/like-post/${postId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ postId: postId })
            })
            .then(response => response.json())
            .then(data => {
                // Actualiza el contador de likes en la interfaz
                const likeCountElement = document.getElementById(`like-count-${postId}`);
                likeCountElement.textContent = data.likes_count;  // Asumiendo que el servidor devuelve el nuevo número de likes
            })
            .catch(error => {
                console.error('Error al dar like:', error);
            });
        }

    </script>
</head>
<body>
    @include('partials.header-2')
    
    @include('partials.home')
    
    @include('partials.footer')
</body>
</html>
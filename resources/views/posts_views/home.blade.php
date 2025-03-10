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
        fetch(`/posts/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ post_id: postId })
        }).then(response => response.json())
          .then(data => {
              document.getElementById(`n_likes-${postId}`).innerText = data.n_likes;
          }).catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    @include('partials.header-2')
    
    @include('partials.home')
    
    @include('partials.footer')
</body>
</html>
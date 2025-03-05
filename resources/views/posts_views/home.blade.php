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
    @include('partials.header-2')
    
    @include('partials.home')
    
    @include('partials.footer')
</body>
</html>
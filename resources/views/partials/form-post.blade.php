@vite('resources/css/posts_styles/create_styles.css')
<main class="main__post">
    <form action="{{ route('posts.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Introduce el título de tu post" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" id="content" class="form-control" rows="5" placeholder="Escribe el contenido de tu post" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Imagen</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>
        <button type="submit" class="btn-primary">Crear Post</button>
    </form>
</main>

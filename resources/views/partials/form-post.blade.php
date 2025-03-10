@vite('resources/css/posts_styles/create_styles.css')
<main class="main__post">
    <form class="post__post_form {{ $errors->any() ? 'post__post_form-error' : '' }}" action="{{ route('posts.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" id="title" class="form-control {{ $errors->has('title') ? 'error' : '' }}" placeholder="Introduce el título de tu post" required>
            @if($errors->has('title'))
                <small class="small-error">{{ $errors->first('title') }}</small>
            @endif
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" id="content" class="form-control {{ $errors->has('description') ? 'error' : '' }}" rows="5" placeholder="Escribe el contenido de tu post" required></textarea>
            @if($errors->has('description'))
                <small class="small-error">{{ $errors->first('description') }}</small>
            @endif
        </div>
        <div class="form-group">
            <label for="image">Imagen</label>
            <input type="file" name="image" id="image" class="form-control-file {{ $errors->has('image') ? 'error' : '' }}">
            @if($errors->has('image'))
                <small class="small-error">{{ $errors->first('image') }}</small>
            @endif
        </div>
        <button type="submit" class="btn-primary">Crear Post</button>
    </form>
</main>

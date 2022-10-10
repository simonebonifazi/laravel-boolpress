@if($post->exists)
<form action="{{ route('admin.posts.update' , $post) }}" enctype="multipart/form-data" method="POST">
    @method('PUT')
    @else
    <form action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" method="POST">
        @endif

        @csrf
        <div class="row">

            <!-- titolo -->
            <div class="mb-3 col-9">
                <label for="title" class="form-label">Titolo </label>
                <input class="form-control  @error('title') is-invalid @enderror" type="text" id="title" name="title"
                    placeholder="inserisci qui il titolo del tuo nuovo post..."
                    value=" {{ old('title', $post->title)  }} " maxlenght="50">
            </div>
            <!-- categoria -->
            <div class="mb-3 col-3">
                <label for="category_id" class="form-label"> Categoria </label>
                <select class="custom-select custom-select-sm" id="category_id" name="category_id">
                    <option value="">Seleziona una categoria</option>
                    @foreach($categories as $category)
                    <option @if(old('category_id' , $post->category_id ) == $category->id) selected @endif
                        value="{{ $category->id }}">{{ $category->label }}</option>
                    @endforeach
                </select>
            </div>
            <!-- content -->
            <div class="mb-3 col-12">
                <label for="content" class="form-label"> Contenuto </label>
                <textarea class="form-control" id="content"
                    name="content"> {{ old('content', $post->content) }} </textarea>
            </div>
            <!-- image -->
            <div class="mb-3 col-10">
                <label for="image" class="form-label">Immagine </label>
                <input class="@error('image') is-invalid @enderror" type="file" id="image" name="image">
            </div>
            <div class="mb-3 col-2">
                <img class="img-fluid"
                    src="{{ $post->image ?? 'https://image.shutterstock.com/image-vector/ui-image-placeholder-wireframes-apps-260nw-1037719204.jpg' }}"
                    alt="preview" id="preview">
                <!-- to fix w/js -->
            </div>
            <!-- checkbox pubblicato -->
            <div class="mb-3 col-12">
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1"
                        @if(old( 'is_published' , $post->is_published)) checked @endif>
                    <label for="is_published" class="form-check-label"> Pubblicato</label>
                </div>
            </div>
            <!-- multi-checkboxs -->
            @if(count($tags))
            <div class="mb-3 col-6">
                <h3> Tags</h3>
                <div class="d-flex">

                    @foreach($tags as $tag)
                    <div class="form-group form-check m-2">
                        <input type="checkbox" id="{{$tag->label}}" name="tags[]" value="{{ $tag->id }}"
                            class="form-check-input" @if(in_array($tag->id, old('tags', $tag_ids ?? []))) checked
                        @endif >
                        <label class="form-check-label" for="{{$tag->label}}"> {{$tag->label}} </label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        <footer class="d-flex justify-content-between align items-center">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-circle-left"> </i> Indietro ...
            </a>

            <button type="submit" class="btn btn-outline-success">
                <i class="fa-solid fa-floppy-disk"></i> Salva!
            </button>
        </footer>
    </form>
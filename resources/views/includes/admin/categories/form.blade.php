@if($category->exists)
<form action="{{ route('admin.categories.update' , $category) }}" method="POST">
    @method('PUT')
    @else
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @endif

        @csrf
        <div class="row">

            <!-- label -->
            <div class="mb-3 col-9">
                <label for="label" class="form-label"> Label </label>
                <input class="form-control  @error('label') is-invalid @enderror" type="text" id="label" name="label"
                    placeholder="inserisci qui il label della tua nuova categoria..."
                    value=" {{ old('label', $category->label)  }} " maxlenght="50">
            </div>
            <!-- color -->
            <div class="mb-3 col-9">
                <label for="color" class="form-label"> Color </label>
                <select class="form-control  @error('color') is-invalid @enderror" id="color" name="color">
                    <option value="">Seleziona colore...</option>
                    @foreach(config('colors') as $color)
                    <option @if(old('color' , $category->color) === $color['value']) selected @endif
                        value="{{$color['value']}}"> {{ $color['name'] }} </option>
                    @endforeach
                </select>
            </div>
        </div>

        <footer class="d-flex justify-content-between align items-center">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-circle-left"> </i> Indietro ...
            </a>

            <button type="submit" class="btn btn-outline-success">
                <i class="fa-solid fa-floppy-disk"></i> Salva!
            </button>
        </footer>
    </form>
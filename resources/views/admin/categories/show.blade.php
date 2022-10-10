@extends('layouts.app')

@section('content')

<header>
    <h1>{{ $category->label }}</h1>
</header>
<div class="clearfix">

    <p class="mb-5"> <strong>Color: </strong> {{ $category->color }} </p>


    <div class="my-3">
        <strong> Creata il: </strong> <time> {{ $category->created_at }}</time>
    </div>
    <div class="my-3">
        <strong> Ultima modifica: </strong> <time> {{ $category->updated_at }}</time>
    </div>
</div>
<footer class="d-flex align-items-center justify-content-between mt-5">

    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
        <i class="fa-solid fa-circle-left"> </i> Indietro ...
    </a>
    <div class="d-flex">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary p-2">
            <i class="fa-solid fa-file-pen"></i> Modifica
        </a>
        <form action="{{ route('admin.categories.destroy', $category->id )}}" method="POST" class="mx-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="fa-solid fa-trash-can"></i> Elimina!
            </button>
        </form>
    </div>
</footer>


@endsection
@extends('layouts.app')

@section('content')



<header class="d-flex justify-content-between align-items-center mb-4">
    <h2> Le tue categorie </h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-success p-2">
        <i class="fa-solid fa-circle-plus"></i> Nuova Categoria
    </a>
</header>


<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Label</th>
            <th scope="col">Color</th>
            <th scope="col">Creato alle:</th>
            <th scope="col">Ultima modifica:</th>
            <th scope="col" class="text-center">Azioni ... </th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <th scope="row">{{ $category->id }}</th>
            <td>{{$category->label}}</td>
            <td>{{$category->color}}</td>
            <td>{{$category->created_at}}</td>
            <td>{{$category->updated_at}}</td>
            <td class="d-flex align-items-center justify-content-around">
                <a href="{{ route('admin.categories.show' , $category ) }}" class="btn btn-sm btn-outline-primary p-2">
                    <i class="fa-solid fa-eye"> </i> Vedi ...
                </a>
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary p-2">
                    <i class="fa-solid fa-file-pen"></i> Modifica
                </a>

                <form action="{{ route('admin.categories.destroy', $category->id )}}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fa-solid fa-trash-can"></i> Elimina!
                    </button>
                </form>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">
                <h4 class="text-center">

                    Nessuna categoria
                </h4>
            </td>
        </tr>
        @endforelse

    </tbody>
</table>
<nav class="mt-4">
    @if($categories->hasPages())
    {{ $categories->links() }}
    @endif
</nav>

@endsection
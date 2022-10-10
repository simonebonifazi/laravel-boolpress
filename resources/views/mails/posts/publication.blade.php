<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questo non è uno spam</title>
</head>

<body>
    <p> Ehi! è stato pubblicato un nuovo post</p>
    <h2>{{$post->title}}</h2>
    <p><strong> Pubblicato il:</strong> {{ $post->created_at}}</p>
    <address> da: {{$post->user->name}} </address>
    <p><strong> Categoria:</strong> {{ $post->category ? $post->category->label : 'nessuna categoria' }}</p>
    <p><strong> Tags:</strong></p>
    @forelse($post->tags as $tag)
    <span>{{$tag->label}}</span> @if ($loop->last) . @else , @endif
    @empty
    Nessun tag
    @endforelse
</body>

</html>
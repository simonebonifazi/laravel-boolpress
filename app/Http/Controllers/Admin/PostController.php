<?php

namespace App\Http\Controllers\Admin;

//importo modelli
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Mail\PostPublicationMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at', 'DESC')->orderBy('created_at', 'DESC')->orderBy('title')->paginate(5);
        $categories = Category::all();
        return view('admin.posts.index', compact('posts','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        //passo un post vuoto per favorire unificazione form
        $post = new Post();
        $categories = Category::select('id', 'label')->get();
        $tags = Tag::select('id', 'label')->get();

        return view('admin.posts.create' , compact('post', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:1|max:50|unique:posts',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
        ],[
            'required' => 'Attenzione, il campo :attribute è obbbligatorio',
            'title.required' => 'Attenzione, compila il campo Titolo per continuare',
            'title.max' => 'Attenzione,il titolo non può avere più di 50 caratteri. Hai già pensato di mettere le informazioni nel contenuto?',
            'title.min' => 'Attenzione, ci dev\'essere un titolo per procedere' ,
            'title.unique' => 'Attenzione, il titolo scelto è già associato ad un altro post',
            'image.image' => 'Il file scelto non è di tipo immagine',
            'image.mimes' => 'Sono ammesse solo immagini in formato .jpeg e .png',
            'tags.exists' => 'uno dei tag selezionati è non valido',
        ]);

        $data = $request->all();
        //slug   
        $data['slug'] = Str::slug($data['title'] , '-');
        //is_published
        $data['is_published'] = array_key_exists('is_published', $data);
        
        
        $data['user_id'] = Auth::id(); 
        
        if(array_key_exists('image', $data)){
            $new_image_url = Storage::put('post_images', $data['image']);
            $data['image'] = $new_image_url;
        };
        $post = new Post();
        $post->fill($data);
        $post->save();
        //se è stato spuntato almeno un checkbox, montalo sul db
        if(array_key_exists('tags', $data))
        {
            $post->tags()->attach($data['tags']);
        }

        //! mails
         if($post->is_published){
            $mail = new PostPublicationMail($post);
            $user = Auth::user()->email;
            Mail::to($user)->send($mail);
        }
        // if($post->is_published){
        //     $mail = new PostPublicationMail($post);
        //     $user_email = Auth::user()->email;
        //     Mail::to($user_email)->send($mail);  
        // }
        
        return redirect()->route('admin.posts.show', compact('post'))
        ->with('message', 'Il post è stato creato con successo!')
        ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::select('id', 'label')->get();
        $tags = Tag::select('id', 'label')->get();
        $tag_ids = $post->tags->pluck('id')->toArray();

        return view('admin.posts.edit', compact('post', 'categories','tags','tag_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        
        $request->validate([
            'title' => ['required','string','min:1','max:50', Rule::unique('posts')->ignore($post->id)],
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
        ],[
            'required' => 'Attenzione, il campo :attribute è obbbligatorio',
            'title.required' => 'Attenzione, compila il campo Titolo per continuare',
            'title.max' => 'Attenzione,il titolo non può avere più di 50 caratteri. Hai già pensato di mettere le informazioni nel contenuto?',
            'title.min' => 'Attenzione, ci dev\'essere un titolo per procedere' ,
            'title.unique' => 'Attenzione, il titolo scelto è già associato ad un altro post',
            'image.image' => 'Il file scelto non è di tipo immagine',
            'image.mimes' => 'Sono ammesse solo immagini in formato .jpeg e .png',
            'tags.exists' => 'uno dei tag selezionati è non valido',

        ]);
        
        $data = $request->all();

        $data['slug'] = Str::slug($data['title'], '-'); 
        
        $post['is_published'] = array_key_exists('is_published', $data);        
        
        
        
        if(array_key_exists('image', $data)){
            if($post->image) Storage::delete($post->image);
            $new_image_url = Storage::put('post_images', $data['image']);
            $post->image = $new_image_url;
        };
        
        $post->update($data);
    
        if(array_key_exists('tags', $data))
        {
            $post->tags()->sync($data['tags']);
        } else{
            $post->tags()->detach();
        };

        return redirect()->route('admin.posts.show', compact('post'))
        ->with('message', 'Il post è stato aggiornato correttamente')
        ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post )
    {
        //ulteriore controllo sul funzionamento di cascade
        // if(count($post->tags)) $post->tags->detach();

         if($post->image) Storage::delete($post->image);

        $post->delete();

        return redirect()->route('admin.posts.index')
        ->with('message', 'Il post è stato eliminato correttamente')
        ->with('type', 'success');
    }

    public function toggle(Post $post)
    {
        $post->is_published = !$post->is_published;
        $post->save();

        $status = $post->is_published ? 'pubblicato' : 'nascosto';
        return redirect()->route('admin.posts.index')
        ->with('message', "Post $post->title $status con successo")
        ->with('type', 'success');
    }
}
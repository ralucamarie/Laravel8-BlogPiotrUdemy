<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

// use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function __construct()
        {
            $this->middleware('auth')
            ->only(['create','store','edit','update','destroy']);
        }
        

    public function index()
    {

        return view(
            'posts.index', 
            [
                'posts'=>BlogPost::latestWithRelations()
                    ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //if I want to authorize user on create.
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated=$request->validated();
        $validated['user_id']=$request->user()->id;

        //creates the model, assignes all properties and saves to DB
        $post=BlogPost::make($validated);
        // $post['user_id'] = auth()->id(); 
        $post->save();

        $hasFile=($request->hasFile('thumbnail'));

        if($request->hasFile('thumbnail')){

            $path=$request->file('thumbnail')->store('thumbnails');
            
            $post->image()->save(
                Image::make(['path'=>$path])
            );
            // $name=$file->storeAs('thumbnails',$post->id.'.'.$file->guessExtension());

        }
          
        $request->session()->flash('status','The blog post was created!');

        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function() use($id){
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')
                ->findOrFail($id);
        });
        $sessionId = session()->getId();

        $counterKey="blog-post-{$id}-counter";
        $usersKey="blog-post-{$id}-users";
        $users=Cache::tags(['blog-post'])->get($usersKey,[]);
        $usersUpdate=[];
        $difference = 0;
        $now=now();

        foreach($users as $session=>$lastVisit){
            if($now->diffInMinutes($lastVisit)>=1){
                $difference--;
            }else {
            $usersUpdate[$session]=$lastVisit;
            }
        }

        if(
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
        ){
            $difference++;
        }

        $usersUpdate[$sessionId]=$now;

        Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);

        if(!Cache::tags(['blog-post'])->has($counterKey)){
            Cache::tags(['blog-post'])->forever($counterKey,1);
        }else{
            Cache::tags(['blog-post'])->increment($counterKey,$difference);
        }

        $counter=Cache::tags(['blog-post'])->get($counterKey);

        return view('posts.show', [
            'posts'=>$blogPost,
            'counter'=>$counter
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=BlogPost::findOrFail($id);
        $this->authorize($post);
        // if (Gate::denies('update-post', $post)){
        //     abort(403, "You cannot edit this message");
        // }

        return view('posts.edit',['post'=>BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post=BlogPost::findOrFail($id);
        $this->authorize($post);
        // if (Gate::denies('update-post', $post)){
        //     abort(403, "You cannot edit this message");
        // }

        $validated = $request->validated();
        $post->fill($validated);

        if($request->hasFile('thumbnail')){
            $path=$request->file('thumbnail')->store('thumbnails');
            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path=$path;
                $post->image->save();
            } else{
                
                $post->image()->save(
                    Image::make(['path'=>$path])

                );
            }
            
            // $name=$file->storeAs('thumbnails',$post->id.'.'.$file->guessExtension());

        }
        $post->save();

        $request->session()->flash('status','Blog post was updated!');
        return redirect()->route('posts.show', ['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=BlogPost::findOrFail($id);
        $this->authorize($post);
        //  if (Gate::denies('delete-post', $post)){
        //     abort(403, "You cannot delete this post");
        // }

        $post->delete();
        session()->flash('status','Blog Post was deleted!');
        return redirect()->route('posts.index'); 
    }
}

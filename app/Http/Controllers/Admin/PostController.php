<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\Category;
// use App\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $validationRules = [
        'title' => 'string|required|max:100',
        'content' => 'string|required',
        'category_id' => 'nullable|exists:categories,id',
        // 'tags' => 'exists:tags,id'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::user();

        $posts = Post::all();

        return view("admin.posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        // $tags = Tag::all();

        return view("admin.posts.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validations
        $request->validate($this->validationRules);

        $newPost = new Post();
        $newPost->fill($request->all());
       
        $newPost->slug = $this->getSlug($request->title);

        // $newPost->user_id = Auth::id();

        $newPost->save();

        // $newPost->tags()->attach($request["tags"]);

        return redirect()->route("admin.posts.index")->with('success',"Il post è stato creato");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // if( $post->user_id != Auth::id() ) {
        //     abort("403");
        // }

        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // if( $post->user_id != Auth::id() ) {
        //     abort("403");
        // }

        $categories = Category::all();
        // $tags = Tag::all();

        return view("admin.posts.edit", compact("post", "categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // if( $post->user_id != Auth::id() ) {
        //     abort("403");
        // }
        
        //validations
        $request->validate($this->validationRules);

        if($post->title != $request->title) {
            $post->slug = $this->getSlug($request->title);
        }

        $post->fill($request->all());

        $post->save();

        // $post->tags()->sync($request->tags);

        return redirect()->route("admin.posts.index")->with('success',"Il post {$post->id} è stato aggiornato");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post = Post::find($request->id);

        // if( $post->user_id != Auth::id() ) {
        //     abort("403");
        // }
        
        $post->delete();

        return redirect()->route("admin.posts.index")->with('success',"Il post {$post->id} è stato eliminato");
    }
    
    /**
     * getSlug - return a unique slug
     *
     * @param  string $title
     * @return string
     */
    private function getSlug($title)
    {
        $slug = Str::of($title)->slug('-');

        $postExist = Post::where("slug", $slug)->first();

        $count = 2;
        
        while($postExist) {
            $slug = Str::of($title)->slug('-') . "-{$count}";
            $postExist = Post::where("slug", $slug)->first();
            $count++;
        }

        return $slug;
    }
}
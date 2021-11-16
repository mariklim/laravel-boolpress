@extends('layouts.guest')
@section('pageContent')
  <div class="row">
    <div class="col-md-12 blog-main">
      <h3 class="pb-3 mb-4 font-italic border-bottom">
        Blog Boolpress
      </h3>

      @foreach ($posts as $post)
      <div class="blog-post">
        <h2 class="blog-post-title">{{$post['title']}}</h2>
        <p class="blog-post-meta">{{$post->created_at->diffForHumans()}} <a href="#">Maria</a></p>
        <p>{{$post['content']}}</p>
        
      </div><!-- /.blog-post -->
      @endforeach


      

    </div><!-- /.blog-main -->
  </div><!-- /.row -->
    
@endsection

   
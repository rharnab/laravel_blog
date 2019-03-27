@extends('layouts.backend.app')
@section('title', 'Post-edit')
@push('css')
<!-- Multi Select Css -->
   
     <link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet"/>

@endpush
@section('content')
<!-- Vertical Layout -->
    <div class="container-fluid">
        <form action="{{route('author.post.update', $post->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
        <div class="row clearfix">
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-8">
                <div class="card">
                    <div class="header">
                        <h2>
                            Edit POST
                        </h2>
                        
                    </div>
                    <div class="body">
                        
                            <label for="email_address">Add Post</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="post" name="title" class="form-control" placeholder="add title" value="{{$post->title}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                     <label for="email_address">Post Image</label>
                                    <input type="file" id="post" name="image" class="form-control" placeholder="add post">
                                </div>
                            </div>
                             <div class="form-group">
                                <input  type="checkbox" name="status" id="publish" value="1" {{ $post->status== true ? 'checked': ''}}>
                                <label for="publish">Publish</label>
                            </div>
                            
                        
                    </div>
                </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Edit Category And Post
                        </h2>
                        
                    </div>
                    <div class="body">
                        
                            
                            
                            <div class="form-group">
                                <div class="form-line {{$errors->has('categories')?'focused error': ''}}">
                                   <label for="category">Select Category</label>
                                   <select name="categories[]" id="category" class="form-control show-tick" data-live-search="true" multiple="">
                                    @foreach($categories as $category)
                                       <option

                                       @foreach($post->categories as $postCategory)
                                       {{$postCategory->id==$category->id ? 'selected' : ''}}
                                       @endforeach
                                         value="{{ $category->id}}">{{$category->name}}

                                     </option>
                                    @endforeach
                                   </select>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-line {{$errors->has('tags')?'focused error': ''}}">
                                   <label for="tag">Select Tag</label>
                                   <select name="tags[]" id="tag" class="form-control show-tick" data-live-search="true" multiple="">
                                    @foreach($tags as $tag)
                                       <option
                                       @foreach($post->tags as $postTag)
                                        {{$postTag->id == $tag->id ? 'selected': ''}}
                                       @endforeach
                                        value="{{ $tag->id }}">{{$tag->name}}
                                      </option>
                                    @endforeach
                                   </select>

                                </div>
                            </div>
                            
                            <a href="{{ url('author/post')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Back</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                       
                    </div>
                </div>
            </div>
        </div> 
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ADD NEW Post
                        </h2>
                        
                    </div>
                    <div class="body"> 
                        <textarea id="tinymce" name="body">{{ $post->body }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        </form>  
    </div>
     <!-- #END# Vertical Layout -->
@endsection

@push('js')

     <script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <script src="{{ asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>
    <script type="text/javascript">
        $(function () {
    

    //TinyMCE
    tinymce.init({
        selector: "textarea#tinymce",
        theme: "modern",
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = '{{asset('assets/backend//plugins/tinymce')}}';
});
    </script>
@endpush
@extends('layouts.backend.app')
@section('title', 'Post-show')
@push('css')
<!-- Multi Select Css -->
   

@endpush
@section('content')
<!-- Vertical Layout -->
    <div class="container-fluid">
        
        <a class="btn btn-sm btn-info" href="{{ url('author/post') }}">Back</a>
        @if($post->is_approved==false)
        <button class="btn btn-sm btn-info pull-right">
            <i class="material-icons">done</i>
                Approve
        </button>
        @else
        <button class="btn btn-sm btn-info pull-right" disabled=""><i class="material-icons">done</i> Approved</button>
        @endif
        <br> <br>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-8">      
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$post->title}}
                            <small>Posted by <strong>{{$post->user->author}}</strong></small>
                        </h2>
                        
                    </div>
                    <div class="body">
                        
                        {!! $post->body !!}
                    </div>
                </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="header bg-info">
                        <h2>
                             Categorys 
                        </h2>
                        
                    </div>
                    <div class="body">
                    	@foreach($post->categories as $category)
                           <option class="label bg-cyan">{{ $category->name }}</option>
                        @endforeach
                       
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="header bg-info">
                        <h2>
                             Tags 
                        </h2>
                        
                    </div>
                    <div class="body">
                    	@foreach($post->tags as $tag)
                           <option class="label bg-cyan">{{ $tag->name }}</option>
                        @endforeach
                       
                    </div>
                </div>

                <div class="card">
                    <div class="header bg-info">
                        <h2>
                             Image  
                        </h2>
                        
                    </div>
                    <div class="body">
                    	<img class="img-responsive" src="{{ asset('storage/post/'.$post->image)   }} ">
                       
                    </div>
                </div>


            </div>

            
        </div> 
        
        
    </div>
     <!-- #END# Vertical Layout -->
@endsection

@push('js')

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
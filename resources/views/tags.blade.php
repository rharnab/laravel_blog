@extends('layouts.frontend.app')

@section('title', 'Tag by Post')


@push('css')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/post/styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/post/responsive.css')}}">
<style type="text/css">

	.favorite_post{
        color: blue;
    }
</style>
@endpush

@section('content')
<div class="slider display-table center-text">
		<h1 class="title display-table-cell"><b>{{$slug}}</b></h1>
	</div><!-- slider -->

	<section class="blog-area section">
		<div class="container">

			<div class="row">
            @if($posts->count() > 0)
				@foreach($posts as $post)
					<div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{asset('storage/post/'.$post->image)}}"></div>

                                <a class="avatar" href="#"><img src="{{ asset('storage/profile/'.$post->user->image)}}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{ route('post.details', $post->slug)}}"><b>{{$post->title}}</b></a></h4>

                                    <ul class="post-footer">
                                        <li>
                                            @guest
                                             <a href="javascript:void(0);" onclick="toastr.info('Please login first.', 'Alert',{
                                                closeButton: true,
                                                progressBar: true,
                                             })" href="#"><i class="ion-heart"></i>{{ $post->favorit_to_users->count() }}</a>
                                            @else

                                             <a href="javascript:void(0);"  onclick="document.getElementById('add-favorite-{{$post->id}}').submit()" class="{{ !Auth::user()->favorite_posts->where('pivot.post_id', $post->id)->count() ==0? 'favorite_post': '' }}"><i class="ion-heart"></i>{{ $post->favorit_to_users->count() }}</a>

                                             <form id="add-favorite-{{$post->id}}" method="post" action="{{ route('post.favorite', $post->id)}}" style="display: none">
                                                 @csrf
                                             </form>

                                            @endguest

                                            {{-- <a href="#"><i class="ion-heart"></i>57</a> --}}

                                        </li>
                                        <li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
                                        <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->

				@endforeach
            @else

                <div class="col-lg-12 col-md-12">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                 <div class="blog-info">
                                    <h4 class="title">Sorry data not found!!!</h4>
                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->

                @endif
			</div><!-- row -->

			<span>{{ $posts->links()}}</span>
			{{-- <a class="load-more-btn" href="#"><b>LOAD MORE</b></a> --}}

		</div><!-- container -->
	</section><!-- section -->




@endsection


@push('js')


@endpush


@extends('layouts.frontend.app')

@section('title')

	{{ $post->slug }}
@endsection

@push('css')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/single_post/styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/single_post/responsive.css')}}">
<style type="text/css">
	.header-bg{
		height: 400px;
		width: 100%;
		background-image: url({{ asset('storage/post/'.$post->image) }});
		background-size: cover;
	}

	.favorite_post{
        color: blue;
    }
</style>
@endpush

@section('content')
<div class="header-bg">
		
</div><!-- slider -->

	<section class="post-area section">
		<div class="container">

			<div class="row">

				<div class="col-lg-8 col-md-12 no-right-padding">

					<div class="main-post">

						<div class="blog-post-inner">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="{{ asset('storage/profile/'.$post->user->image)}}" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>{{ $post->user->name}}</b></a>
									<h6 class="date">{{ $post->created_at->diffForHumans()}}</h6>
								</div>

							</div><!-- post-info -->

							<h3 class="title"><a href="#"><b>{{$post->title}}</b></a></h3>

							<div class="para">{!! html_entity_decode($post->body)  !!}</div>

							<div class="post-image"><img src="{{ asset('storage/post/'.$post->image) }}" alt="Blog Image"></div>

							

							<ul class="tags">
								@foreach($post->tags as $tag)
								<li><a href="{{ route('tag.post', $tag->slug) }}">{{ $tag->name}} </a></li>
								@endforeach
								
							</ul>
						</div><!-- blog-post-inner -->

						<div class="post-icons-area">
							<ul class="post-icons">
								<li>
									@guest
									<a href="javascript:void(0);" onclick="toastr.info('Please login first.', 'Alert',{
                                        closeButton: true,
                                        progressBar: true,
                                     })" href="#"><i class="ion-heart"></i>{{ $post->favorit_to_users->count() }}
                                    </a>
                                    @else
                                    <a href="javascript:void(0);" onclick="document.getElementById('add-favorite-{{$post->id}}').submit()" class="{{!Auth::user()->favorite_posts->where('pivot.post_id', $post->id)->count() == 0? 'favorite_post': ''}}"><i class="ion-heart"></i>{{ $post->favorit_to_users->count() }}
                                    </a>
                                     <form id="add-favorite-{{$post->id}}" method="post" action="{{ route('post.favorite', $post->id)}}" style="display: none">
                                                 @csrf
                                             </form>
									@endguest
								</li>
								<li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
								<li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
							</ul>

							<ul class="icons">
								<li>SHARE : </li>
								<li><a href="#"><i class="ion-social-facebook"></i></a></li>
								<li><a href="#"><i class="ion-social-twitter"></i></a></li>
								<li><a href="#"><i class="ion-social-pinterest"></i></a></li>
							</ul>
						</div>

						{{-- <div class="post-footer post-info">

							<div class="left-area">
								<a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
							</div>

							<div class="middle-area">
								<a class="name" href="#"><b>Katy Liu</b></a>
								<h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
							</div>

						</div> --}}<!-- post-info -->


					</div><!-- main-post -->
				</div><!-- col-lg-8 col-md-12 -->

				<div class="col-lg-4 col-md-12 no-left-padding">

					<div class="single-post info-area">

						<div class="sidebar-area about-area">
							<h4 class="title"><b>{{$post->user->name}}</b></h4>
							<p>{{ $post->user->about}}</p>
						</div>

						

						<div class="tag-area">

							<h4 class="title"><b>TAG CLOUD</b></h4>
							<ul>
								@foreach($post->categories as $category)
								<li><a href="{{ route('category.post', $category->slug) }}">{{$category->name }}</a></li>
								@endforeach
								
							</ul>

						</div><!-- subscribe-area -->

					</div><!-- info-area -->

				</div><!-- col-lg-4 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section><!-- post-area -->


	<section class="recomended-area section">
		<div class="container">
			<div class="row">
				@foreach($randoms as $random)
					  <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{asset('storage/post/'.$random->image)}}"></div>

                                <a class="avatar" href="#"><img src="{{ asset('storage/profile/'.$random->user->image)}}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{ route('post.details', $random->slug)}}"><b>{{$random->title}}</b></a></h4>

                                    <ul class="post-footer">
                                        <li>
                                            @guest
                                             <a href="javascript:void(0);" onclick="toastr.info('Please login first.', 'Alert',{
                                                closeButton: true,
                                                progressBar: true,
                                             })" href="#"><i class="ion-heart"></i>{{ $random->favorit_to_users->count() }}</a>
                                            @else

                                             <a href="javascript:void(0);"  onclick="document.getElementById('add-favorite-{{$random->id}}').submit()" class="{{ !Auth::user()->favorite_posts->where('pivot.post_id', $random->id)->count() ==0? 'favorite_post': '' }}"><i class="ion-heart"></i>{{ $post->favorit_to_users->count() }}</a>

                                             <form id="add-favorite-{{$random->id}}" method="post" action="{{ route('post.favorite', $random->id)}}" style="display: none">
                                                 @csrf
                                             </form>

                                            @endguest

                                            {{-- <a href="#"><i class="ion-heart"></i>57</a> --}}

                                        </li>
                                        <li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
                                        <li><a href="#"><i class="ion-eye"></i>{{$random->view_count}}</a></li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
				@endforeach
			</div><!-- row -->

		</div><!-- container -->
	</section>

	<section class="comment-section">
		<div class="container">
			<h4><b>POST COMMENT</b></h4>
			<div class="row">

				<div class="col-lg-8 col-md-12">
					@guest
						<h5>Please <a href="{{url('login')}}">Login</a> First</h5>
					@else
					<div class="comment-form">
						<form method="post" action="{{ route('comment.store', $post->id)}}">
							@csrf
							<div class="row">
								<div class="col-sm-12">
									<textarea name="comment" rows="2" class="text-area-messge form-control"
										placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
								</div><!-- col-sm-12 -->
								<div class="col-sm-12">
									<button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
								</div><!-- col-sm-12 -->

							</div><!-- row -->
						</form>
					</div><!-- comment-form -->
					@endguest

					<h4><b>COMMENTS({{ $post->comments->count() }})</b></h4>
					@if($post->comments->count() > 0)
					@foreach($post->comments as $comment)
					<div class="commnets-area">

						<div class="comment">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="{{asset('storage/profile/'. $comment->user->image)}}" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>{{ $comment->user->name}}</b></a>
									<h6 class="date">{{ $comment->created_at->diffForHumans()}}</h6>
								</div>

								{{-- <div class="right-area">
									<h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
								</div> --}}

							</div><!-- post-info -->

							<p>{{ $comment->comment}}</p>

						</div>

						{{-- <div class="comment">
							<h5 class="reply-for">Reply for <a href="#"><b>Katy Lui</b></a></h5>

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>Katy Liu</b></a>
									<h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
								</div>

								<div class="right-area">
									<h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
								</div>

							</div><!-- post-info -->

							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
								ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur
								Ut enim ad minim veniam</p>

						</div> --}}

					</div><!-- commnets-area -->

					@endforeach
					@else

					<span class="more-comment-btn" href="#"><b>Not Comment Found</span>
					@endif

				</div><!-- col-lg-8 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section>


@endsection


@push('js')


@endpush


@extends('layouts.backend.app')
@section('title', 'Dashboard')
@push('css')

@endpush
@section('content')
 <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Post</div>
                            <div class="number count-to" data-from="0" data-to="{{ $posts }}" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">favorites</i>
                        </div>
                        <div class="content">
                            <div class="text">Favorite Post</div>
                            <div class="number count-to" data-from="0" data-to="{{ $total_pending_post }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">librery_books</i>
                        </div>
                        <div class="content">
                            <div class="text">Pending Post</div>
                            <div class="number count-to" data-from="0" data-to="{{ $total_pending_post }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Views</div>
                            <div class="number count-to" data-from="0" data-to="{{ $all_views }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box bg-green  hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">apps</i>
                        </div>
                        <div class="content">
                            <div class="text">Categories</div>
                            <div class="number count-to" data-from="0" data-to="{{ $category_count }}" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>

                    <div class="info-box bg-grey hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">labels</i>
                        </div>
                        <div class="content">
                            <div class="text">Tags</div>
                            <div class="number count-to" data-from="0" data-to="{{ $tag_count }}" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>

                    <div class="info-box bg-light-green hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">account_circle</i>
                        </div>
                        <div class="content">
                            <div class="text">Author</div>
                            <div class="number count-to" data-from="0" data-to="{{ $author_count }}" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>

                    <div class="info-box bg-cyan hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">fiber_new</i>
                        </div>
                        <div class="content">
                            <div class="text">Today Author</div>
                            <div class="number count-to" data-from="0" data-to="{{ $new_authros_today }}" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="header">
                            <h2>Most Popular Post</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                        <td>Rank</td>
                                        <td>Title</td>
                                        <td>Author</td>
                                        <td>Views</td>
                                        <td>Favorite</td>
                                        <td>Comments</td>
                                        <td>Status</td>
                                        <td>Action</td>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($popular_post as $post)
                                        <tr>
                                            <td>{{ +1 }}</td>
                                            <td>{{ str_limit($post->title,15) }}</td>
                                            <td>{{ $post->User->name }}</td>
                                            <td>{{ $post->view_count }}</td>
                                            <td>{{ $post->favorit_to_users_count }}</td>
                                            <td>{{ $post->comments_count }}</td>
                                            <td>{{ $post->favorit_to_users_count }}</td>
                                            <td>
                                                @if($post->status == true)

                                                        <span class="label bg-green">Published</span>
                                                @else
                                                <span class="label bg-red">Pending</span>
        
                                                @endif
                                            </td>

                                            <td>
                                                <a target="_blank" href="{{ route('post.details', $post->slug) }}" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
          

            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Top 10 active Author</h2>
                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Rank List</th>
                                            <th>Name</th>
                                            <th>Posts</th>
                                            <th>Comments</th>
                                            <th>favorite</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($active_authors->count() > 0)
                                       @foreach($active_authors as $author)

                                       <tr>
                                           <td>{{ +1 }}</td>
                                           <td>{{ $author->name }}</td>
                                           <td>{{ $author->posts_count }}</td>
                                           <td>{{ $author->comments_count }}</td>
                                           <td>{{ $author->favorite_posts_count }}</td>
                                       </tr>
    
                                       @endforeach
                                       @else
                                        <tr><td>Sorry Active Author Not found!!!</td></tr>
                                       @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->
               
            </div>
        </div>
@endsection
@push('js')
 <script src="{{ asset('assets/backend/js/pages/index.js')}}"></script>
 <!-- Morris Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('assets/backend/plugins/morrisjs/morris.js')}}"></script>

    <!-- ChartJs -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js')}}plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js')}}plugins/flot-charts/jquery.flot.js"></script>
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js')}}plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js')}}plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js')}}plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js')}}plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js')}}plugins/jquery-sparkline/jquery.sparkline.js"></script>
@endpush

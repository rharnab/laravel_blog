@extends('layouts.backend.app')
@section('title', 'favorite')
@push('css')

<!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')
 <div class="container-fluid">
            
           
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Favorite Post TABLE
                                ({{ $posts->count()}})
                            </h2>
                           
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th><i class="material-icons">favorites</i></th>
                                            {{-- <th><i class="material-icons">comments</i></th> --}}
                                             <th><i class="material-icons">visibility</i></th>
                                            {{-- <th>Updated At</th> --}}
                                            <th>Active</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                           <th>ID</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th><i class="material-icons">favorites</i></th>
                                            {{-- <th><i class="material-icons">comments</i></th> --}}
                                             <th><i class="material-icons">visibility</i></th>
                                            {{-- <th>Updated At</th> --}}
                                            <th>Active</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                       @foreach($posts as $key=>$post)
                                       
                                        <tr>
                                            <td>{{$post->id}}</td>
                                            <td>{{str_limit($post->title,'10')}}</td>
                                            <td>{{$post->user->name}}</td>
                                            <td>{{$post->favorit_to_users->count()}}</td>
                                            <td>{{$post->view_count}}</td>
                                            
                                            <td>
                                            	 
                                                <a href="{{route('admin.post.show', $post->id)}}" class="btn btn-primary">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                
                                                <button onclick="removepost({{$post->id}})" type="button" class="btn btn-danger">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                <form id="post-remove-{{$post->id}}" action="{{route('post.favorite',$post->id)}}" method="post" style="display: none">
                                                    @csrf
                                                   
                                                </form>
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
            <!-- #END# Exportable Table -->
        </div>

@endsection
@push('js')
 <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.0.1/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
        function removepost(id)
        {
            const swalWithBootstrapButtons = Swal.mixin({
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                event.preventDefault()
                 $('#post-remove-'+id).submit();
              } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons(
                  'Cancelled',
                  'Your data is safe :)',
                  'error'
                )
              }
            })
        }

        function approval(id)
        {
            const swalWithBootstrapButtons = Swal.mixin({
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              text: "You won't be approved this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, Approve it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
            }).then((result) => {
              if (result.value) {
                event.preventDefault()
                 $('#post-approved-'+id).submit();
              } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
              ) {
                swalWithBootstrapButtons(
                  'Cancelled',
                  'Your data is safe :)',
                  'error'
                )
              }
            })
        }
    </script>
@endpush
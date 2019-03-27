@extends('layouts.backend.app')
@section('title', 'post-index')
@push('css')

<!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')
 <div class="container-fluid">
            <div class="block-header">
               <a class="btn btn-primary" href="{{url('admin/post/create')}}"><i class="material-icons">add</i><span>Add post</span></a>
            </div>
           
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Post TABLE
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
                                            <th>View Count</th>
                                            <th>Is Approved</th>
                                            <th>Status</th>
                                            <th>Created_at</th>
                                            {{-- <th>Updated At</th> --}}
                                            <th>Active</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                           <th>ID</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>View Count</th>
                                            <th>Is Approved</th>
                                            <th>Status</th>
                                            <th>Created_at</th>
                                            <th>Active</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                @if($posts->count() > 0)
                                       @foreach($posts as $key=>$post)
                                       
                                        <tr>
                                            <td>{{$post->id}}</td>
                                            <td>{{str_limit($post->title,'10')}}</td>
                                            <td>{{$post->user->name}}</td>
                                            <td>{{$post->view_count}}</td>
                                            <td>
                                                @if($post->is_approved==true)
                                                <span class="badge bg-blue">Approved</span>
                                                @else
                                                <span class="badge bg-pink">Pendding</span>
                                                @endif
                                                
                                            </td>
                                            <td>
                                                @if($post->status==true)
                                                <span class="badge bg-blue">Published</span>
                                                @else
                                                <span class="badge bg-pink">Pendding</span>
                                                @endif
                                            </td>
                                            <td>{{$post->created_at}}</td>
                                            {{-- <td>{{$post->updated_at}}</td> --}}
                                            <td>
                                                <a href="{{route('admin.post.show', $post->id)}}" class="btn btn-primary">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a href="{{route('admin.post.edit', $post->id)}}" class="btn btn-primary">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <button onclick="deletepost({{$post->id}})" type="button" class="btn btn-danger">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                <form id="post-delete-{{$post->id}}" action="{{route('admin.post.destroy',$post->id)}}" method="post" style="display: none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                       @endforeach
                                       @else

                                        <tr><td colspan="8">Post not found!!!</td></tr>
                                       @endif
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
        function deletepost(id)
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
                 $('#post-delete-'+id).submit();
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
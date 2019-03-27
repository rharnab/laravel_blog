@extends('layouts.backend.app')
@section('title', 'tag-create')
@push('css')
@endpush
@section('content')
<!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit TAG
                            </h2>
                            
                        </div>
                        <div class="body">
                            <form action="{{route('admin.tag.update', $tag->id)}}" method="post">
                            	@csrf
                            	@method('put')
                                <label for="email_address">Add Tag</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="tag" name="name" class="form-control" placeholder="add tag" value="{{$tag->name}}">
                                    </div>
                                </div>
                                
                                <a href="{{ url('admin/tag')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Back</a>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
@endsection

@push('js')
@endpush
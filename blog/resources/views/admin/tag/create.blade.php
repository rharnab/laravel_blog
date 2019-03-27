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
                                ADD NEW TAG
                            </h2>
                            
                        </div>
                        <div class="body">
                            <form action="{{route('admin.tag.store')}}" method="post">
                            	@csrf
                                <label for="email_address">Add Tag</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="tag" name="name" class="form-control" placeholder="add tag">
                                    </div>
                                </div>
                                
                                <a href="{{ url('admin/tag')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Back</a>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
@endsection

@push('js')
@endpush
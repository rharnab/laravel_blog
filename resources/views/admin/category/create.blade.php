@extends('layouts.backend.app')
@section('title', 'category-create')
@push('css')
@endpush
@section('content')
<!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ADD NEW Category
                            </h2>
                            
                        </div>
                        <div class="body">
                            <form action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
                            	@csrf
                                <label for="email_address">Add category</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="category" name="name" class="form-control" placeholder="add category">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" id="category" name="image" class="form-control" placeholder="add category">
                                    </div>
                                </div>
                                
                                <a href="{{ url('admin/category')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Back</a>
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
@extends('backend.layouts.master')

@section('content')

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Create Album</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">Albums</li>
                            <li class="breadcrumb-item active">Create Album</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{\session()->get('success')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">

                        <div class="body">
                            <form action="{{route('album.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Name" name="name" value="{{old('name')}}">
                                        </div>
                                    </div>



                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="pictures" class="form-label">pictures</label>
                                                <input type="file" class="form-control" id="pictures" name="pictures" multiple>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
            <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
            <script> $('#lfm').filemanager('image');</script>
@endsection

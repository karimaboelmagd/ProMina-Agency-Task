@extends('backend.layouts.master')


@section('content')

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Albums</h2>
                        <ul class="breadcrumb float-left">
                            <li class="breadcrumb-item active">Album</li>
                        </ul>
                        <p class="float-right">Total Albums : {{App\Models\Album::count()}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    @include('backend.layouts.notification')
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Albums</strong> List</h2>
                            <br>
                            <a href="{{route('album.create')}}" class="btn btn-primary btn-sm float-left" data-toggle="tooltip" data-placement="bottom" title="Create Album"><i class="fas fa-plus"></i> Create Album</a>
                            <br>
                        </div>

                        <div class="body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>pictures</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($albums as $album)
                                        <tr>
                                            <th>{{$loop->iteration}}</th>
                                            <th>{{$album->name}}</th>
                                            <th>
                                                <img src="/upload/album_pictures/{{$album->pictures}}" class="img-fluid zoom" style="max-width:80px" alt="{{$album->pictures}}">
                                            </th>

                                            <th>
                                                <a href="{{route('album.edit', $album->id)}}" data-toggle="tooltip" title="Edit" class="float-left btn btn-sm btn-outline-warning" data-placement="bottom">
                                                    <i class=" fas fa-edit">
                                                    </i>
                                                </a>
                                                <form class="float-left ml-1" action="{{route('album.destroy', $album->id)}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('delete')
                                                    <a href="" data-toggle="tooltip" title="Delete" data-id="{{$album->id}}" class="dltBtn btn btn-sm btn-outline-danger" data-placement="bottom">
                                                        <i class=" fas fa-trash-alt">
                                                        </i>
                                                    </a>
                                                </form>
                                            </th>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection

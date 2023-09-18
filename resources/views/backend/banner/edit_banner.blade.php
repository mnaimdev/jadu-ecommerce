@extends('master')

@section('content')
    <div class="container" style="margin-top: 100px;">
        <a href="{{ route('banner') }}" class="btn btn-primary my-3 mx-3">List</a>

        <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Banner</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('banner.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if (session('banner_update'))
                            <div class="alert alert-success">
                                {{ session('banner_update') }}
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <input type="text" name="name" value="{{ $banner->name }}" class="form-control">
                            @error('name')
                                <strong class="text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror

                            <input type="hidden" name="id" value="{{ $banner->id }}">

                        </div>

                        <div class="form-group mb-3">
                            <input type="file" name="image" class="form-control"
                                onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        </div>

                        <div class="form-group mb-3">
                            <img width="200" src="{{ asset('/uploads/banner') }}/{{ $banner->image }}" id="blah"
                                alt="">
                        </div>


                        <div class="form-group mb-3">
                            <input type="text" name="discount" value="{{ $banner->discount }}">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

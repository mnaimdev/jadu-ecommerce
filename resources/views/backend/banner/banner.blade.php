@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-md-8">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-header">
                        <h3 class="mt-2">Show Banner</h3>
                    </div>
                    <div class="card-body">

                        @if (session('banner_del'))
                            <div class="alert alert-danger">
                                {{ session('banner_del') }}
                            </div>
                        @endif

                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Banner Name</th>
                                <th>Banner Image</th>
                                <th>Banner Discount</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($banners as $sl => $banner)
                                <tr>
                                    <td>{{ $sl + 1 }}</td>
                                    <td>{{ $banner->name }}</td>
                                    <td>
                                        <img class="rounded-circle" width="70" height="70"
                                            src="{{ asset('/uploads/banner') }}/{{ $banner->image }}" alt="">
                                    </td>

                                    <td>
                                        <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-primary">Edit</a>

                                        <a href="{{ route('banner.delete', $banner->id) }}"
                                            class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-sm-12 col-md-4">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-header">
                        <h3 class="mt-2">Add Banner</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if (session('banner'))
                                <div class="alert alert-success">
                                    {{ session('banner') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Banner Name</label>
                                <select name="name" class="form-control">
                                    <option>Select Banner Name</option>
                                    <option value="Header Banner">Header Banner</option>
                                    <option value="Mid Banner">Mid Banner</option>
                                    <option value="Offer Banner">Offer Banner</option>
                                </select>
                                @error('name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Banner Image</label>
                                <input type="file" class="form-control" name="image"
                                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                @error('image')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror

                            </div>


                            <div class="form-group">
                                <label>Discount %</label>
                                <input type="text" name="discount" class="form-control">
                                @error('discount')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror

                            </div>

                            <div class="form-group">
                                <img width="200" id="blah" alt="">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

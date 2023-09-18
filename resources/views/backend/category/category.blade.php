@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-md-8">
                <div class="card" style="margin-top: 100px;">
                    <div class="card-header">
                        <h3 class="mt-2">Show Category</h3>
                    </div>
                    <div class="card-body">

                        @if (session('category_del'))
                            <div class="alert alert-danger">
                                {{ session('category_del') }}
                            </div>
                        @endif

                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Category Image</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($categories as $sl => $category)
                                <tr>
                                    <td>{{ $sl + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <img class="rounded-circle" width="70" height="70"
                                            src="{{ asset('/uploads/category') }}/{{ $category->image }}" alt="">
                                    </td>

                                    <td>
                                        <a href="{{ route('category.edit', $category->id) }}"
                                            class="btn btn-primary">Edit</a>

                                        <a href="{{ route('category.delete', $category->id) }}"
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
                        <h3 class="mt-2">Add Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if (session('category'))
                                <div class="alert alert-success">
                                    {{ session('category') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" class="form-control" name="name">
                                @error('name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Category Image</label>
                                <input type="file" class="form-control" name="image"
                                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                @error('image')
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

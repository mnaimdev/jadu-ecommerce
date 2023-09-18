@extends('master')


@section('content')
    <div class="container" style="margin-top: 100px;">

        <div class="row">
            <div class="col-sm-12 col-lg-8 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Subcategory List</h3>
                    </div>
                    <div class="card-body">

                        @if (session('sub_del'))
                            <div class="alert alert-danger">
                                {{ session('sub_del') }}
                            </div>
                        @endif

                        <table class="table">
                            <tr>
                                <td>SL</td>
                                <td>Subcategory Name</td>
                                <td>Category Name</td>
                                <td>Action</td>
                            </tr>
                            @foreach ($subcategories as $sl => $subcategory)
                                <tr>
                                    <td>{{ $sl + 1 }}</td>
                                    <td>{{ $subcategory->name }}</td>
                                    <td>{{ $subcategory->category->name }}</td>

                                    <td>
                                        <a href="{{ route('subcategory.edit', $subcategory->id) }}"
                                            class="btn btn-primary">Edit</a>

                                        <a href="{{ route('subcategory.delete', $subcategory->id) }}"
                                            class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Subcategory</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subcategory.store') }}" method="POST">
                            @csrf

                            @if (session('subcategory'))
                                <div class="alert alert-success">
                                    {{ session('subcategory') }}
                                </div>
                            @endif


                            <div class="form-group mb-3">
                                <label>Subcategory Name</label>
                                <input type="text" name="name" class="form-control">
                                @error('name')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <select name="category_id" class="form-control">
                                    <option selected disabled>-- Select Category --</option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('category_id')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <button class="btn btn-primary" type="submit">Add</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

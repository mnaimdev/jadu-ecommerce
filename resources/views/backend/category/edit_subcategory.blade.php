@extends('master')

@section('content')
    <div class="container" style="margin-top: 100px;">
        <a href="{{ route('subcategory') }}" class="btn btn-primary my-3">List</a>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mt-3">Edit Subcategory</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subcategory.update') }}" method="POST">
                            @csrf

                            @if (session('update_sub'))
                                <div class="alert alert-success">
                                    {{ session('update_sub') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <input type="hidden" value="{{ $subcategory->id }}" name="id">

                                <select name="category_id" class="form-control">
                                    <option>-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option {{ $category->id == $subcategory->category_id ? 'selected' : '' }}
                                            value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sub Category</label>
                                <input type="text" class="form-control" name="name" value="{{ $subcategory->name }}">

                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

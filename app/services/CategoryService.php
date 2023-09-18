<?php

namespace App\services;

use App\Models\Category;
use Image;

class CategoryService
{

    private $name, $image;


    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }


    public function setImage($value)
    {
        $this->image = $value;
        return $this;
    }


    public function categoryList()
    {
        $categories = Category::all();
        return $categories;
    }


    public function store()
    {

        // save image into public
        $image = $this->image;
        $extension = $image->getClientOriginalExtension();
        $fileName = rand(111111, 999999) . '.' . $extension;

        Image::make($image)->save(public_path('/uploads/category/' . $fileName));

        $imageurl = url('/uploads/category/' . $fileName);


        // save category
        $category = new Category();
        $category->name = $this->name;
        $category->image = $fileName;
        $category->imageurl = $imageurl;
        $category->save();
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return $category;
    }


    public function update($id)
    {
        // update category
        $category = Category::findOrFail($id);
        $category->name = $this->name;
        $category->update();
    }

    public function updateCategory($id)
    {

        // remove image from public
        $savedImage = Category::findOrFail($id)->image;
        $deletedFrom = public_path('/uploads/category/' . $savedImage);
        unlink($deletedFrom);

        // save image
        $image = $this->image;
        $extension = $image->getClientOriginalExtension();
        $fileName = rand(111111, 999999) . '.' . $extension;

        Image::make($image)->save(public_path('/uploads/category/' . $fileName));

        $imageurl = url('/uploads/category/' . $fileName);

        // update category
        $category = Category::findOrFail($id);
        $category->name = $this->name;
        $category->image = $fileName;
        $category->imageurl = $imageurl;
        $category->update();
    }


    public function delete($id)
    {
        // remove image from public
        $savedImage = Category::findOrFail($id)->image;
        $deletedFrom = public_path('/uploads/category/' . $savedImage);
        unlink($deletedFrom);

        Category::findOrFail($id)->delete();
    }
}

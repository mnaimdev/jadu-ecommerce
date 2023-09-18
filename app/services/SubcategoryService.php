<?php

namespace App\services;

use App\Models\Subcategory;

class SubcategoryService
{
    private $name, $categoryId;


    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }


    public function setCategoryId($value)
    {
        $this->categoryId = $value;
        return $this;
    }


    public function subcategoryList()
    {
        $subcategories = Subcategory::all();
        return $subcategories;
    }


    public function store()
    {
        // save category
        $category = new Subcategory();
        $category->name = $this->name;
        $category->category_id = $this->categoryId;
        $category->save();
    }


    public function edit($id)
    {
        $category = Subcategory::findOrFail($id);
        return $category;
    }


    public function update($id)
    {
        // update category
        $category = Subcategory::findOrFail($id);
        $category->name = $this->name;
        $category->category_id = $this->categoryId;
        $category->update();
    }



    public function delete($id)
    {

        Subcategory::findOrFail($id)->delete();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\services\SubcategoryService;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{

    public function subcategory()
    {
        try {
            $service = new SubcategoryService();
            $subcategories = $service->subcategoryList();
            $categories = Category::all();

            return view('backend.category.subcategory', [
                'subcategories'    => $subcategories,
                'categories'       => $categories,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function subcategoryStore(Request $request)
    {

        $request->validate([
            'name'          => 'required|unique:categories,name',
            'category_id'   => 'required',
        ], [
            'name.required'             => 'Name is required',
            'category_id.required'      => 'Category is required',
        ]);

        try {
            $service = new SubcategoryService();
            $service->setName($request->name)
                ->setCategoryId($request->category_id)
                ->store();

            return back()->with('subcategory', 'Subcategory Added Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function subcategoryEdit($id)
    {
        try {
            $service = new SubcategoryService();
            $subcategory = $service->edit($id);
            $categories = Category::all();

            return view('backend.category.edit_subcategory', [
                'subcategory'      => $subcategory,
                'categories'       => $categories,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function subcategoryUpdate(Request $request)
    {

        try {

            $service = new SubcategoryService();
            $service->setName($request->name)
                ->setCategoryId($request->category_id)
                ->update($request->id);


            return back()->with('update_sub', 'Subcategory Updated Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function subcategoryDelete($id)
    {
        try {
            $service = new SubcategoryService();
            $service->delete($id);

            return back()->with('sub_del', 'Subcategory Deleted Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function subcategoryList($id)
    {
        try {
            $subcategory = Subcategory::where('category_id', $id)->get();
            return response()->json($subcategory, 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

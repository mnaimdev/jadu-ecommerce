<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category()
    {
        try {
            $service = new CategoryService();
            $categories = $service->categoryList();
            return view('backend.category.category', [
                'categories'    => $categories,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function categoryStore(Request $request)
    {

        $request->validate([
            'name'      => 'required|unique:categories,name',
            'image'     => 'required|image|mimes:png,jpg'
        ]);

        try {
            $service = new CategoryService();
            $service->setName($request->name)
                ->setImage($request->image)
                ->store();

            return back()->with('category', 'Category Added Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function categoryEdit($id)
    {
        try {
            $service = new CategoryService();
            $category = $service->edit($id);

            return view('backend.category.edit_category', [
                'category'      => $category,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function categoryUpdate(Request $request)
    {

        try {


            if ($request->image == '') {
                $service = new CategoryService();
                $service->setName($request->name)
                    ->update($request->id);
            } else {
                $service = new CategoryService();
                $service->setName($request->name)
                    ->setImage($request->image)
                    ->updateCategory($request->id);
            }

            return back()->with('category_update', 'Category Updated Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function categoryDelete($id)
    {
        try {
            $service = new CategoryService();
            $service->delete($id);

            return back()->with('category_del', 'Category Deleted Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function categoryList()
    {
        try {
            $categories = Category::select('id', 'name', 'imageurl')->get();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

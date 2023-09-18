<?php

namespace App\Http\Controllers;

use App\services\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function banner()
    {
        try {
            $service = new BannerService();
            $banners = $service->bannerList();
            return view('backend.banner.banner', [
                'banners'    => $banners,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function bannerStore(Request $request)
    {

        $request->validate([
            'name'      => 'required|unique:banners,name',
            'image'     => 'required|image|mimes:png,jpg',
            'discount'  => 'required',
        ]);

        try {
            $service = new BannerService();
            $service->setName($request->name)
                ->setImage($request->image)
                ->setDiscount($request->discount)
                ->store();

            return back()->with('banner', 'Banner Added Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function bannerEdit($id)
    {
        try {
            $service = new BannerService();
            $banner = $service->edit($id);

            return view('backend.banner.edit_banner', [
                'banner'      => $banner,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function bannerUpdate(Request $request)
    {

        try {


            if ($request->image == '') {
                $service = new BannerService();
                $service->setName($request->name)
                    ->setDiscount($request->discount)
                    ->update($request->id);
            } else {
                $service = new BannerService();
                $service->setName($request->name)
                    ->setImage($request->image)
                    ->setDiscount($request->discount)
                    ->updateCategory($request->id);
            }

            return back()->with('banner_update', 'Banner Updated Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function bannerDelete($id)
    {
        try {
            $service = new BannerService();
            $service->delete($id);

            return back()->with('banner_del', 'Banner Deleted Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

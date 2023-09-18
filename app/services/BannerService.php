<?php

namespace App\services;

use App\Models\Banner;
use Image;

class BannerService
{
    private $name, $image, $discount;


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


    public function setDiscount($value)
    {
        $this->discount = $value;
        return $this;
    }


    public function bannerList()
    {
        $banners = Banner::all();
        return $banners;
    }


    public function store()
    {

        // save image into public
        $image = $this->image;
        $extension = $image->getClientOriginalExtension();
        $fileName = rand(111111, 999999) . '.' . $extension;

        Image::make($image)->save(public_path('/uploads/banner/' . $fileName));

        $imageurl = url('/uploads/banner/' . $fileName);


        // save category
        $banner = new Banner();
        $banner->name = $this->name;
        $banner->image = $fileName;
        $banner->imageurl = $imageurl;
        $banner->discount = $this->discount;
        $banner->save();
    }


    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return $banner;
    }


    public function update($id)
    {
        // update category
        $banner = Banner::findOrFail($id);
        $banner->name = $this->name;
        $banner->discount = $this->discount;
        $banner->update();
    }

    public function updateCategory($id)
    {

        // remove image from public
        $savedImage = Banner::findOrFail($id)->image;
        $deletedFrom = public_path('/uploads/banner/' . $savedImage);
        unlink($deletedFrom);

        // save image
        $image = $this->image;
        $extension = $image->getClientOriginalExtension();
        $fileName = rand(111111, 999999) . '.' . $extension;

        Image::make($image)->save(public_path('/uploads/banner/' . $fileName));

        $imageurl = url('/uploads/banner/' . $fileName);

        // update category
        $banner = Banner::findOrFail($id);
        $banner->name = $this->name;
        $banner->image = $fileName;
        $banner->imageurl = $imageurl;
        $banner->discount = $this->discount;
        $banner->update();
    }


    public function delete($id)
    {
        // remove image from public
        $savedImage = Banner::findOrFail($id)->image;
        $deletedFrom = public_path('/uploads/banner/' . $savedImage);
        unlink($deletedFrom);

        Banner::findOrFail($id)->delete();
    }
}

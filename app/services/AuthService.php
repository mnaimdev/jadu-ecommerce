<?php

namespace App\services;

use App\Models\PassReset;
use Illuminate\Support\Facades\Notification;


use App\Models\User;
use App\Models\UserToken;
use App\Notifications\PassResetNotification;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $name, $email, $password, $password_confirmation, $phone, $image, $address, $country, $city;

    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    public function setEmail($value)
    {
        $this->email = $value;
        return $this;
    }


    public function setAddress($value)
    {
        $this->address = $value;
        return $this;
    }


    public function setCountry($value)
    {
        $this->country = $value;
        return $this;
    }



    public function setCity($value)
    {
        $this->city = $value;
        return $this;
    }


    public function setImage($value)
    {
        $this->image = $value;
        return $this;
    }


    public function setPassword($value)
    {
        $this->password = $value;
        return $this;
    }

    public function setPhone($value)
    {
        $this->phone = $value;
        return $this;
    }

    public function setConfirmPassword($value)
    {
        $this->password_confirmation = $value;
        return $this;
    }


    public function register()
    {

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);
        $user->phone = $this->phone;
        $user->user_type = 'Customer';
        $user->name = $this->name;
        $user->save();

        return $user;
    }


    public function login()
    {
        if (User::where('phone', $this->phone)->exists()) {
            $user = User::where('phone', $this->phone)->first();
            $token = rand(1000000, 9999999);


            // delete previous user token
            UserToken::where('user_id', $user->id)->delete();

            // insert data into user tokens table
            $userToken = new UserToken();
            $userToken->user_id = $user->id;
            $userToken->token = $token;
            $userToken->created_at = Carbon::now();
            $userToken->save();

            return $token;
        }

        if (User::where('email', $this->email)->exists()) {
            $user = User::where('email', $this->email)->first();

            $token = rand(1000000, 9999999);

            // delete previous user token
            UserToken::where('user_id', $user->id)->delete();


            // insert data into user tokens table
            $userToken = new UserToken();
            $userToken->user_id = $user->id;
            $userToken->token = $token;
            $userToken->created_at = Carbon::now();
            $userToken->save();

            return $token;
        }
    }


    public function profile($token)
    {

        return $this->image;

        die();


        $userToken = UserToken::where('token', $token)->first();
        $user = User::where('id', $userToken->user_id)->first();


        // if there is no password
        if ($this->password == '') {

            // if there is image then
            if ($this->image != '') {
                $image = $this->image;
                $extension = $image->getClientOriginalExtension();
                $fileName = 'user' . '-' . rand(111111, 999999) . '.' . $extension;

                Image::make($image)->save(public_path('/uploads/customer/' . $fileName));


                $user->name = $this->name;
                $user->country = $this->country;
                $user->city = $this->city;
                $user->address = $this->address;
                $user->image = $fileName;
                $user->save();
            }

            // if there is not image then
            else {
                $user->name = $this->name;
                $user->country = $this->country;
                $user->city = $this->city;
                $user->address = $this->address;
                $user->save();
            }
        }


        // if there is password then
        else {
            // if there is image then
            if ($this->image != '') {
                $image = $this->image;
                $extension = $image->getClientOriginalExtension();
                $fileName = 'user' . '-' . rand(111111, 999999) . '.' . $extension;

                Image::make($image)->save(public_path('/uploads/customer/' . $fileName));


                $user->name = $this->name;
                $user->country = $this->country;
                $user->city = $this->city;
                $user->address = $this->address;
                $user->image = $fileName;
                $user->password = bcrypt($this->password);
                $user->save();
            }

            // if there is not image then
            else {
                $user->name = $this->name;
                $user->country = $this->country;
                $user->city = $this->city;
                $user->address = $this->address;
                $user->password = bcrypt($this->password);
                $user->save();
            }
        }
    }


    public function logout($token)
    {
        // delete user token
        UserToken::where('token', $token)->delete();
    }


    public function forget($email)
    {
        $user = User::where('email', $email)->first();

        $token = rand(111111, 99999999);

        // delete pass reset token
        PassReset::where('user_id', $user->id)->delete();

        $reset = new PassReset();
        $reset->user_id = $user->id;
        $reset->token = $token;
        $reset->save();


        Notification::send($user, new PassResetNotification($token));
    }


    public function reset($token)
    {
        $reset = PassReset::where('token', $token)->first();
        $userId = User::where('id', $reset->user_id)->first()->id;

        // update user password
        $user = User::findOrFail($userId);
        $user->password = bcrypt($this->password);
        $user->update();

        // remove user token
        PassReset::where('token', $token)->delete();
    }
}

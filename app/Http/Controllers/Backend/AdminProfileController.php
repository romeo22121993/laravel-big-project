<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Route;

class AdminProfileController extends Controller
{

    /**
     * Admin profile page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function AdminProfile(){

        $id = Auth::user()->id;
        $adminData = User::find( $id );

        return view( 'admin.admin_profile_view', compact( 'adminData' ) );

    }

    public function AdminProfileEdit(){

        $id = Auth::user()->id;
//        $editData = Admin::find($id);
        $editData = User::find($id);
        return view('admin.admin_profile_edit', compact('editData'));

    }


    public function AdminProfileStore(Request $request){

        $id   = Auth::user()->id;
        $data = User::find($id);
        $data->name  = $request->name;
        $data->email = $request->email;

        if ( $request->file('profile_photo_path' ) ) {
            $file = $request->file('profile_photo_path');
            @unlink(public_path('upload/user_images/'.$data->profile_photo_path));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.profile')->with($notification);

    } // end method


    public function AdminChangePassword(){
        return view('admin.admin_change_password');
    }

    public function AdminUpdateChangePassword(Request $request){

//        $validateData = $request->validate([
//            'oldpassword' => 'required',
//            'password'    => 'required|confirmed',
//        ]);

        $request->validate([
            'oldpassword'   => ['required', new MatchOldPassword],
            'password'      => ['required'],
            'password_confirmation' => ['same:password'],
        ]);


        $hashedPassword = Auth::user()->password;
        if ( Hash::check($request->oldpassword,$hashedPassword ) ) {
            $admin = User::find(Auth::id());
            $admin->password = Hash::make($request->password);
            $admin->save();
            Auth::logout();
            return redirect()->route('admin.logout');
        } else {
            $errors = array(
                'message' => 'Wrong current password',
                'alert-type' => 'success'
            );
            return redirect()->back()->with( $errors );
        }

    }// end method

}

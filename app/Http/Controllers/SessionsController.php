<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\CamerasController;
use Illuminate\Http\Request;
use Auth;
use DB;

class SessionsController extends Controller
{
    /*
        GET    /login       -> create()     // 显示登录页面
        POST   /login       -> store()      // 创建新会话（登录）
        DELETE /logout      -> destroy()    // 销毁会话（退出登录）
    */
    // GET /login - 显示登录页面
    public function create() {
        return view('sessions.create');
    }

    // POST /login - 创建新会话（登录）
    public function store(Request $request) {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        //{"email":"kevin@10ware.com","password":"kevin816"}
        //return $credentials;

        // $email = $request->email;
        // $password = $request->password;
        // if (Auth::attempt(['email' => $email, 'password' => $password])) {
        if (Auth::attempt($credentials)) {
            // 该用户存在于数据库，且邮箱和密码相符合
            session()->flash('success', '欢迎回来！');
            //return redirect()->route('users.show', [Auth::user()]);

            $user = Auth::user();
            $user_id = $user->id;
            //$user_id = 3; //for test
            $camera = DB::table('cameras')->where('user_id', $user_id)->first();
            if ($camera) {
                $camera_id = $camera->id;
            } else {
                $camera_id = 0;
            }
            return redirect()->route('cameras', $camera_id);

        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back(); // return redirect('/');
        }
    }

    // DELETE /logout - 销毁会话（退出登录）
    public function destroy() {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
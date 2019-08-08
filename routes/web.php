<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('posts', 'Admin\Posts@index');
});

Route::get('/fb_login', function () {
    session_start();
    $fb = new Facebook\Facebook([
        'app_id' => '864551767265446',
        'app_secret' => '452c636f7c4d77ddc787360f84cbdb59',
        'default_graph_version' => 'v4.0'
    ]);
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email']; // Optional permissions
    $loginUrl = $helper->getLoginUrl(url('/fb_callback'), $permissions);
    return view('frontend.index', ['loginUrl' => $loginUrl]);
});

Route::get('/fb_callback', function () {
    session_start();
    $fb = new Facebook\Facebook([
        'app_id' => '864551767265446',
        'app_secret' => '452c636f7c4d77ddc787360f84cbdb59',
        'default_graph_version' => 'v4.0'
    ]);
    $helper = $fb->getRedirectLoginHelper();
    $access_token = $helper->getAccessToken();
    $response = $fb->get('/me?fields=email,name', $access_token);
    //var_dump($response);
    $me = $response->getGraphUser();
    echo 'Logged in as ' . $me->getEmail();
    echo 'ID' . $me->getId();

    $user = DB::table('users')->where('email', $me->getEmail())->where('fb_id', $me->getId())->first();
    if ($user != null) {
        //login 
        echo 'login success';
    } else {
        $user = DB::table('users')->where('email', $me->getEmail())
            ->where('fb_id', null)->first();
        if ($user != null) {
            //thong bao email nay da ton tai trong he thong
            echo 'email da ton tai trong he thong';
        } else {
            DB::table('users')->insert([
                'name' => $me->getName(),
                'email' => $me->getEmail(),
                'avatar' => 'https://graph.facebook.com/' . $me->getId() . '/picture?type=normal',
                'fb_id' => $me->getId()
            ]);
            //chuyen user vao profile 
            echo 'Dang nhap thanh cong';
        }
    }
});
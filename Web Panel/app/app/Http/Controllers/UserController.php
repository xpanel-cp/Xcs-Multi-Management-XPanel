<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Traffic;
use App\Models\Users;
use App\Models\Admins;
use App\Models\Servers;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admins');
    }
    public function index()
    {
        $user = Auth::user();
        $password_auto = Str::random(8);
        if($user->permission=='admin')
        {
            $users = Users::orderBy('id', 'desc')->get();
        }
        else{
            $users = Users::where('customer_user', $user->username)->orderby('id', 'desc')->get();
        }
        $settings = Settings::all();
        $servers = Servers::all();
        $packages = Packages::all();
        $permission=$user->permission;
        return view('users.home', compact('users', 'settings','password_auto','permission','servers','packages'));
    }
    public function create()
    {
        $password_auto = Str::random(8);
        return view('users.create', compact('password_auto'));
    }

    public function newuser(Request $request)
    {
        $user = Auth::user();
        if ($user->permission == 'admin') {
            $request->validate([
                'pack' => 'required|string',
                'username' => 'required|string',
                'password' => 'required|string',
                'email' => 'nullable|string',
                'mobile' => 'nullable|string',
                'desc' => 'nullable|string',
            ]);



            $package = Packages::where('id', $request->pack)->get();
            $server = Servers::where('id', $package[0]->server)->get();
            $day=$package[0]->day;

            $start_inp = date("Y-m-d");
            $finishdate = date('Y-m-d', strtotime($start_inp . " + $day days"));
            $check_user = Users::where('username', $request->username)->count();
            if ($check_user < 1) {
                // set post fields
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                    'password' => $request->password,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'multiuser' => $package[0]->multiuser,
                    'traffic' => $package[0]->traffic,
                    'type_traffic' => 'gb',
                    'expdate' => $finishdate,
                    'desc' => $request->desc
                ];

                $ch = curl_init($server[0]->link . '/api/adduser');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                $traffic = $package[0]->traffic * 1024;
                if ($response['message'] == 'User Created') {
                    DB::beginTransaction();
                    Users::create([
                        'server' => $package[0]->server,
                        'username' => $request->username,
                        'password' => $request->password,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'multiuser' => $package[0]['multiuser'],
                        'start_date' => $start_inp,
                        'end_date' => $finishdate,
                        'date_one_connect' => '0',
                        'customer_user' => $user->username,
                        'status' => 'active',
                        'traffic' => $traffic,
                        'package' => $request->pack,
                        'desc' => $request->desc
                    ]);

                    Traffic::create([
                        'username' => $request->username,
                        'download' => '0',
                        'upload' => '0',
                        'total' => '0'
                    ]);
                    DB::commit();
                }
            }

        }else {
                $request->validate([
                    'pack' => 'required|string',
                    'email' => 'nullable|string',
                    'mobile' => 'nullable|string',
                    'desc' => 'nullable|string'
                ]);
                $user_credit = Admins::where('username', $user->username)->get();
                $user_id = Users::where('customer_user', $user->username)->count();
                $user_id = $user_id + 1;
                $account = $user->username . $user_id;
                $chars = "abcdefghijklmnopqrstuvwxyz1234567890";
                $password = substr(str_shuffle($chars), 0, 6);
                $check_user = Users::where('username', $account)->count();
                if ($check_user < 1) {
                    $account = $user->username . $user_id;
                } else {
                    $randname = substr(str_shuffle($chars), 0, 2);
                    $user_id = $user_id + 2;
                    $account = $user->username . $randname . $user_id;
                }
                $package = Packages::where('id', $request->pack)->get();
                $server = Servers::where('id', $package[0]->server)->get();
                $day=$package[0]->day;

                $start_inp = date("Y-m-d");
                $finishdate = date('Y-m-d', strtotime($start_inp . " + $day days"));
                $check_user = Users::where('username', $account)->count();
                if($user_credit[0]->credit>$package[0]->amount) {
                    if ($check_user < 1) {
                        // set post fields
                        $post = [
                            'token' => $server[0]->token,
                            'username' => $account,
                            'password' => $password,
                            'email' => $request->email,
                            'mobile' => $request->mobile,
                            'multiuser' => $package[0]->multiuser,
                            'traffic' => $package[0]->traffic,
                            'type_traffic' => 'gb',
                            'expdate' => $finishdate,
                            'desc' => $request->desc
                        ];

                        $ch = curl_init($server[0]->link . '/api/adduser');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                        $response = curl_exec($ch);
                        $response = json_decode($response, true);
                        curl_close($ch);

                        $traffic = $package[0]->traffic * 1024;
                        if ($response['message'] == 'User Created') {
                            DB::beginTransaction();
                            Users::create([
                                'server' => $package[0]->server,
                                'username' => $account,
                                'password' => $password,
                                'email' => $request->email,
                                'mobile' => $request->mobile,
                                'multiuser' => $package[0]->multiuser,
                                'start_date' => $start_inp,
                                'end_date' => $finishdate,
                                'date_one_connect' => '0',
                                'customer_user' => $user->username,
                                'status' => 'active',
                                'traffic' => $traffic,
                                'package' => $request->pack,
                                'desc' => $request->desc
                            ]);

                            Traffic::create([
                                'username' => $account,
                                'download' => '0',
                                'upload' => '0',
                                'total' => '0'
                            ]);
                            DB::commit();

                            $credit=$user_credit[0]->credit-$package[0]->amount;
                            Admins::where('username', $user->username)->update(['credit' => $credit]);
                            $pkname=$package[0]->title;
                            TransRess::create([
                                'desc_trans' => "Credit withdrawal (Create Account: $account | Package: $pkname)",
                                'amount_trans' => $package[0]->amount,
                                'date_time' => time(),
                                'username_trans' => $user->username
                            ]);
                        }
                    }
                }
                else{
                    return redirect()->back()->with('error', 'Insufficient wallet balance.');
                }

            }


        return redirect()->intended(route('users'));
    }

    public function activeuser(Request $request,$username)
    {
        if (!is_string($username)) {
            abort(400, 'Not Valid Username');
        }
        $user = Auth::user();
        if($user->permission=='admin') {
            $check_user = Users::where('username', $username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                ];

                $ch = curl_init($server[0]->link . '/api/active');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Activated') {
                    Users::where('username', $username)->update(['status' => 'active']);
                }
            }
        }
        else{
            $check_user = Users::where('username', $username)->where('customer_user', $user->username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                ];

                $ch = curl_init($server[0]->link . '/api/active');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Activated') {
                    Users::where('username', $username)->update(['status' => 'active']);
                }
            }
        }

        return redirect()->back()->with('success', 'Activated');
    }
    public function deactiveuser(Request $request,$username)
    {
        if (!is_string($username)) {
            abort(400, 'Not Valid Username');
        }
        $user = Auth::user();
        if($user->permission=='admin') {
            $check_user = Users::where('username',$username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                ];

                $ch = curl_init($server[0]->link . '/api/deactive');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);
                if ($response['message'] == 'User Deactivated') {
                    Users::where('username', $username)->update(['status' => 'deactive']);
                }
            }
        }
        else{
            $check_user = Users::where('username', $username)->where('customer_user', $user->username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                ];

                $ch = curl_init($server[0]->link . '/api/deactive');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Deactivated') {
                    Users::where('username', $username)->update(['status' => 'deactive']);
                }
            }
        }
        return redirect()->back()->with('success', 'Deactivated');

    }
    public function reset_traffic(Request $request,$username)
    {
        if (!is_string($username)) {
            abort(400, 'Not Valid Username');
        }
        $user = Auth::user();
        if($user->permission=='admin') {
            $check_user = Users::where('username',$username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                ];

                $ch = curl_init($server[0]->link . '/api/retraffic');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);
                if ($response['message'] == 'User Reset Traffic') {
                    Traffic::where('username', $username)->update(['download' => '0', 'upload' => '0', 'total' => '0']);
                }
            }
        }
        else
        {
            $check_user = Users::where('username', $username)->where('customer_user', $user->username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                ];

                $ch = curl_init($server[0]->link . '/api/retraffic');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Reset Traffic') {
                    Traffic::where('username', $username)->update(['download' => '0', 'upload' => '0', 'total' => '0']);
                }
            }
        }
        return redirect()->back()->with('success', 'Reset Traffic');
    }

    public function delete(Request $request,$username)
    {
        if (!is_string($username)) {
            abort(400, 'Not Valid Username');
        }
        $user = Auth::user();
        if($user->permission=='admin')
        {
            $check_user = Users::where('username',$username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                ];

                $ch = curl_init($server[0]->link . '/api/delete');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Deleted' OR $response['message'] == 'Not Exist User') {
                    Users::where('username', $username)->delete();
                    Traffic::where('username', $username)->delete();
                }
            }
        }
        else {
            $check_user = Users::where('username', $username)->where('customer_user', $user->username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                ];

                $ch = curl_init($server[0]->link . '/api/delete');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Deleted' OR $response['message'] == 'Not Exist User') {
                    Users::where('username', $username)->delete();
                    Traffic::where('username', $username)->delete();
                }
            }
        }
        return redirect()->back()->with('success', 'Deleted');
    }
    public function delete_bulk(Request $request)
    {

        $user = Auth::user();
        if ($user->permission == 'admin') {
            foreach ($request->usernamed as $username) {
                $check_user = Users::where('username',$username)->count();
                if ($check_user > 0) {
                    $check_user = Users::where('username', $username)->get();
                    $server = Servers::where('id', $check_user[0]->server)->get();
                    $post = [
                        'token' => $server[0]->token,
                        'username' => $request->username,
                    ];

                    $ch = curl_init($server[0]->link . '/api/delete');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);

                    if ($response['message'] == 'User Deleted' OR $response['message'] == 'Not Exist User') {
                        Users::where('username', $username)->delete();
                        Traffic::where('username', $username)->delete();
                    }
                }
            }
        } else {
            foreach ($request->usernamed as $username) {
                $check_user = Users::where('username', $username)->where('customer_user', $user->username)->count();
                if ($check_user > 0) {
                    $check_user = Users::where('username', $username)->get();
                    $server = Servers::where('id', $check_user[0]->server)->get();
                    $post = [
                        'token' => $server[0]->token,
                        'username' => $request->username,
                    ];

                    $ch = curl_init($server[0]->link . '/api/delete');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);

                    if ($response['message'] == 'User Deleted' OR $response['message'] == 'Not Exist User') {
                        Users::where('username', $username)->delete();
                        Traffic::where('username', $username)->delete();
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Deleted');
    }

    public function renewal(Request $request)
    {
        $request->validate([
            'username_re' => 'required|string',
            'pack' => 'required|numeric',
            're_date' => 'required|string',
            're_traffic' => 'required|string'
        ]);
        $newdate = date("Y-m-d");
        $user = Auth::user();
        if($user->permission=='admin') {
            $check_user = Users::where('username', $request->username_re)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $request->username_re)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $package = Packages::where('id', $check_user[0]->package)->get();
                $day=$package[0]->day;
                $newdate = date('Y-m-d', strtotime($newdate . " + $day days"));

                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username_re,
                    'day_date' => $day,
                    're_date' => $request->re_date,
                    're_traffic' => $request->re_traffic,
                ];

                $ch = curl_init($server[0]->link . '/api/renewal');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Renewal') {
                    Users::where('username', $request->username_re)->update(['status' => 'active', 'end_date' => $newdate]);
                    if ($request->re_date == 'yes') {
                        Users::where('username', $request->username_re)->update(['start_date' => date("Y-m-d")]);
                    }
                    if ($request->re_traffic == 'yes') {
                        Traffic::where('username', $request->username_re)->update(['download' => '0', 'upload' => '0', 'total' => '0']);
                    }
                }

                if($request->pack!=$check_user[0]->package)
                {
                    $package = Packages::where('id', $request->pack)->get();
                    $day=$package[0]->day;
                    $newdate = date('Y-m-d', strtotime($newdate . " + $day days"));
                    $post = [
                        'token' => $server[0]->token,
                        'username' => $request->username_re,
                        'password' => $check_user[0]->password,
                        'email' => $check_user[0]->email,
                        'mobile' => $check_user[0]->mobile,
                        'multiuser' => $package[0]->multiuser,
                        'traffic' => $package[0]->traffic,
                        'type_traffic' => 'gb',
                        'activate' => $check_user[0]->status,
                        'expdate' => $newdate,
                        'desc' => $check_user[0]->desc,
                    ];

                    $ch = curl_init($server[0]->link . '/api/edituser');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);

                    if ($response['message'] == 'User Updated') {
                        Users::where('username', $request->username_re)->update(['package' => $request->pack]);
                    }
                }
            }
        }
        else
        {
            $check_user = Users::where('username', $request->username_re)->where('customer_user', $user->username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $request->username_re)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $package = Packages::where('id', $check_user[0]->package)->get();
                $day=$package[0]->day;
                $newdate = date('Y-m-d', strtotime($newdate . " + $day days"));
                $user_credit = Admins::where('username', $user->username)->get();
                echo $user_credit[0]->credit."|".$package[0]->amount;
                if($user_credit[0]->credit>=$package[0]->amount) {
                    $post = [
                        'token' => $server[0]->token,
                        'username' => $request->username_re,
                        'day_date' => $day,
                        're_date' => $request->re_date,
                        're_traffic' => $request->re_traffic,
                    ];

                    $ch = curl_init($server[0]->link . '/api/renewal');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);

                    if ($response['message'] == 'User Renewal') {
                        Users::where('username', $request->username_re)->update(['status' => 'active', 'end_date' => $newdate]);
                        if ($request->re_date == 'yes') {
                            Users::where('username', $request->username_re)->update(['start_date' => date("Y-m-d")]);
                        }
                        if ($request->re_traffic == 'yes') {
                            Traffic::where('username', $request->username_re)->update(['download' => '0', 'upload' => '0', 'total' => '0']);
                        }
                        $credit=$user_credit[0]->credit-$package[0]->amount;
                        Admins::where('username', $user->username)->update(['credit' => $credit]);
                        $pkname=$package[0]->title;
                        $pkaccount=$package[0]->amount;
                        TransRess::create([
                            'desc_trans' => "Credit withdrawal (Renewal Account: $pkaccount | Package: $pkname)",
                            'amount_trans' => $package[0]->amount,
                            'date_time' => time(),
                            'username_trans' => $user->username
                        ]);
                    }

                    if ($request->pack != $check_user[0]->package) {
                        $package = Packages::where('id', $request->pack)->get();
                        $day = $package[0]->day;
                        $newdate = date('Y-m-d', strtotime($newdate . " + $day days"));
                        $post = [
                            'token' => $server[0]->token,
                            'username' => $request->username_re,
                            'password' => $check_user[0]->password,
                            'email' => $check_user[0]->email,
                            'mobile' => $check_user[0]->mobile,
                            'multiuser' => $package[0]->multiuser,
                            'traffic' => $package[0]->traffic,
                            'type_traffic' => 'gb',
                            'activate' => $check_user[0]->status,
                            'expdate' => $newdate,
                            'desc' => $check_user[0]->desc,
                        ];

                        $ch = curl_init($server[0]->link . '/api/edituser');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                        $response = curl_exec($ch);
                        $response = json_decode($response, true);
                        curl_close($ch);

                        if ($response['message'] == 'User Updated') {
                            Users::where('username', $request->username_re)->update(['package' => $request->pack]);
                        }
                    }
                    return redirect()->back()->with('success', 'Renewal Success');
                }
                else{

                    return redirect()->back()->with('error', 'Insufficient wallet balance.');
                }
            }
        }


    }
    public function renewal_edit(Request $request,$username)
    {
        if (!is_string($username)) {
            abort(400, 'Not Valid Username');
        }
        $user = Auth::user();
        if ($user->permission == 'admin') {
            $check_user = Users::where('username', $username)->count();
            if ($check_user > 0) {
                $packages = Packages::all();
                $pack_id = Users::where('username', $username)->get();
                $pack = $pack_id[0]->package;
                return view('users.renewal', compact('packages', 'username', 'pack'));
        } else {
            return redirect()->back()->with('success', 'Not User');
        }
        }
        else{
            $check_user = Users::where('username', $username)->where('customer_user', $user->username)->count();
            if ($check_user > 0) {
                $packages = Packages::all();
                $pack_id = Users::where('username', $username)->get();
                $pack = $pack_id[0]->package;
                return view('users.renewal', compact('packages', 'username', 'pack'));
            } else {
                return redirect()->back()->with('success', 'Not User');
            }
        }

    }
    public function edit(Request $request,$username)
    {
        if (!is_string($username)) {
            abort(400, 'Not Valid Username');
        }
        $user = Auth::user();
        if($user->permission=='admin') {
            $check_user = Users::where('username', $username)->count();
            if ($check_user > 0) {
                $user = Users::where('username', $username)->get();
                $show = $user[0];
                return view('users.edit', compact('show'));
            } else {
                return redirect()->back()->with('success', 'Not User');
            }
        }
        else{
            $check_user = Users::where('username', $username)->where('customer_user', $user->username)->count();
            if ($check_user > 0) {
                $user = Users::where('username', $username)->get();
                $show = $user[0];
                return view('users.edit', compact('show'));
            } else {
                return redirect()->back()->with('success', 'Not User');
            }
        }

    }
    public function update(Request $request)
    {
        $request->validate([
            'username'=>'required|string',
            'password'=>'required|string',
            'email'=>'nullable|string',
            'mobile'=>'nullable|string',
            'desc'=>'nullable|string'
        ]);

        $user = Auth::user();
        if($user->permission=='admin') {
            $check_user = Users::where('username', $request->username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $request->username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $package = Packages::where('id', $check_user[0]->package)->get();
                    $post = [
                        'token' => $server[0]->token,
                        'username' => $request->username,
                        'password' => $request->password,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'multiuser' => $package[0]->multiuser,
                        'traffic' => $package[0]->traffic,
                        'type_traffic' => 'gb',
                        'activate' => $check_user[0]->status,
                        'expdate' => $check_user[0]->end_date,
                        'desc' => $request->desc,
                    ];

                    $ch = curl_init($server[0]->link . '/api/edituser');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);

                    if ($response['message'] == 'User Updated') {
                        Users::where('username', $request->username)
                            ->update([
                                'password' => $request->password,
                                'email' => $request->email,
                                'mobile' => $request->mobile,
                                'desc' => $request->desc
                            ]);
                    }

            }
        }
        else
        {
            $check_user = Users::where('username', $request->username)->where('customer_user', $user->username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $request->username)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $package = Packages::where('id', $check_user[0]->package)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username,
                    'password' => $request->password,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'multiuser' => $package[0]->multiuser,
                    'traffic' => $package[0]->traffic,
                    'type_traffic' => 'gb',
                    'activate' => $check_user[0]->status,
                    'expdate' => $check_user[0]->end_date,
                    'desc' => $request->desc,
                ];

                $ch = curl_init($server[0]->link . '/api/edituser');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Updated') {
                    Users::where('username', $request->username)
                        ->update([
                            'password' => $request->password,
                            'email' => $request->email,
                            'mobile' => $request->mobile,
                            'desc' => $request->desc
                        ]);
                }

            }
        }
        return redirect()->back()->with('success', 'Update Success');
    }

    public function change_server(Request $request)
    {
        $request->validate([
            'username_re'=>'required|string',
            'serverid'=>'required|string'
        ]);
        $user = Auth::user();
        if($user->permission=='admin') {
            $check_user = Users::where('username', $request->username_re)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $request->username_re)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $package = Packages::where('id', $check_user[0]->package)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username_re,
                ];

                $ch = curl_init($server[0]->link . '/api/delete');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Deleted' OR $response['message'] == 'Not Exist User') {
                    $server = Servers::where('id', $request->serverid)->get();
                    $post = [
                        'token' => $server[0]->token,
                        'username' => $request->username_re,
                        'password' => $check_user[0]->password,
                        'email' => $check_user[0]->email,
                        'mobile' => $check_user[0]->mobile,
                        'multiuser' => $package[0]->multiuser,
                        'traffic' => $check_user[0]->traffic,
                        'type_traffic' => 'mb',
                        'expdate' => $check_user[0]->end_date,
                        'desc' => $check_user[0]->desc
                    ];

                    $ch = curl_init($server[0]->link . '/api/adduser');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);

                    if ($response['message'] == 'User Created') {
                        Users::where('username', $request->username_re)->update(['server' => $request->serverid]);
                    }

                }

            }
        }
        else
        {
            $check_user = Users::where('username', $request->username_re)->where('customer_user', $user->username)->count();
            if ($check_user > 0) {
                $check_user = Users::where('username', $request->username_re)->get();
                $server = Servers::where('id', $check_user[0]->server)->get();
                $package = Packages::where('id', $check_user[0]->package)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $request->username_re,
                ];

                $ch = curl_init($server[0]->link . '/api/delete');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                $response = json_decode($response, true);
                curl_close($ch);

                if ($response['message'] == 'User Deleted' OR $response['message'] == 'Not Exist User') {
                    $server = Servers::where('id', $request->serverid)->get();
                    $post = [
                        'token' => $server[0]->token,
                        'username' => $request->username_re,
                        'password' => $check_user[0]->password,
                        'email' => $check_user[0]->email,
                        'mobile' => $check_user[0]->mobile,
                        'multiuser' => $package[0]->multiuser,
                        'traffic' => $check_user[0]->traffic,
                        'type_traffic' => 'mb',
                        'expdate' => $check_user[0]->end_date,
                        'desc' => $check_user[0]->desc
                    ];

                    $ch = curl_init($server[0]->link . '/api/adduser');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $response = json_decode($response, true);
                    curl_close($ch);

                    if ($response['message'] == 'User Created') {
                        Users::where('username', $request->username_re)->update(['server' => $request->serverid]);
                    }

                }

            }
        }
        return redirect()->back()->with('success', 'Change Server Success');
    }

}

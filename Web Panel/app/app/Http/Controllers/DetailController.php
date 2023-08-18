<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Servers;
use App\Models\Packages;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $key)
    {
        if (!is_string($key)) {
            abort(400, 'Not Valid Username');
        }
        $key_org=$key;
        $key=base64_decode($key);
        $key=explode('#',$key);
        $id=$key[0];
        $username=$key[1];
        $created=$key[2];
        $check_user = Users::where('id', $id)->where('username', $username)->where('created_at', $created)->count();
        if ($check_user > 0) {
            $user = Users::where('id', $id)->where('username', $username)->where('created_at', $created)->get();
            $servers = Servers::all();
            return view('detail', compact('user', 'servers', 'key_org'));
        }
        else{
            exit(view('access'));
        }
    }
    public function update(Request $request, $key)
    {
        if (!is_string($key)) {
            abort(400, 'Not Valid Username');
        }
        $request->validate([
            'serverid' => 'required|string'
        ]);
        $key = base64_decode($key);
        $key = explode('#', $key);
        $id = $key[0];
        $username = $key[1];
        $created = $key[2];
        $check_user = Users::where('id', $id)->where('username', $username)->where('created_at', $created)->count();
        if ($check_user > 0) {
            $user = Users::where('id', $id)->where('username', $username)->where('created_at', $created)->get();
            $server_id = $user[0]->server;
            $package_id = $user[0]->package;
            $server = Servers::where('id', $server_id)->get();
            $package = Packages::where('id', $package_id)->get();
            $post = [
                'token' => $server[0]->token,
                'username' => $username,
            ];

            $ch = curl_init($server[0]->link . '/api/delete');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            curl_close($ch);

            if ($response['message'] == 'User Deleted' or $response['message'] == 'Not Exist User') {
                $server = Servers::where('id', $request->serverid)->get();
                $post = [
                    'token' => $server[0]->token,
                    'username' => $username,
                    'password' => $user[0]->password,
                    'email' => $user[0]->email,
                    'mobile' => $user[0]->mobile,
                    'multiuser' => $package[0]->multiuser,
                    'traffic' => $user[0]->traffic,
                    'type_traffic' => 'mb',
                    'expdate' => $user[0]->end_date,
                    'desc' => $user[0]->desc
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
                    return redirect()->back()->with('success', 'Change Server Success');
                }

            }
        }
    }


}

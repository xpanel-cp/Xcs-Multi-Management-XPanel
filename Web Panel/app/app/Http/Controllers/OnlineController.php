<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Process\ProcessResult;
use Auth;
use App\Models\Servers;
use Illuminate\Support\Facades\DB;
use App\Models\Users;


class OnlineController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admins');

    }
    public function check()
    {
        $user = Auth::user();
        if($user->permission=='reseller')
        {
            exit(view('access'));
        }
    }
    public function kill_pid(Request $request,$pid)
    {
        if (!is_numeric($pid)) {
            abort(400, 'Not Valid Username');
        }
        Process::run("sudo kill -9 {$pid}");
        return redirect()->back()->with('success', 'Killed');
    }

    public function kill_user(Request $request,$username)
    {
        if (!is_string($username)) {
            abort(400, 'Not Valid Username');
        }
        Process::run("sudo killall -u {$username}");
        return redirect()->back()->with('success', 'Killed');
    }
    public function index()
    {
        $servers=Servers::all();
        $data=[];
        foreach ($servers as $server) {
            $ch = curl_init($server->link . '/api/' . $server->token . '/online');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $response = json_decode($response, true);
            curl_close($ch);
            if ($httpCode == 200 and !empty($response[0]['username'])) {

                if($response[0]['connection']=='one connection')
                {
                    $color='#269393';
                }
                else
                {
                    $color='#dc2626';
                }
                $user = Auth::user();
                if($user->permission=='reseller') {
                    $check_user = Users::where('customer_user', $user->username)->where('username', $response[0]['username'])->count();
                    if ($check_user > 0) {
                        $data[] = [
                            "server" => $server->name,
                            "username" => $response[0]['username'],
                            "color" => $color,
                            "ip" => $response[0]['ip'],
                            "pid" => $response[0]['pid']
                        ];
                    }
                }
                else {
                    $data[] = [
                        "server" => $server->name,
                        "username" => $response[0]['username'],
                        "color" => $color,
                        "ip" => $response[0]['ip'],
                        "pid" => $response[0]['pid']
                    ];
                }
            }
            }
// Now $results array holds the responses for each server

        $data = json_decode(json_encode($data));
        return view('users.online', compact('data'));
    }
    public function filtering()
    {
        $data = [];
        $serverip = $_SERVER["SERVER_ADDR"];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://check-host.net/check-tcp?host=" . $serverip.":".env('PORT_SSH')."&max_nodes=50");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = ["Accept: application/json", "Cache-Control: no-cache"];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        $array = json_decode($response, true);
        $resultlink = "https://check-host.net/check-result/" . $array["request_id"];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $resultlink);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = ["Accept: application/json", "Cache-Control: no-cache"];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        sleep(3);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $array2 = json_decode($server_output, true);
        foreach ($array2 as $key => $value) {
            $flag = str_replace(".node.check-host.net", "", $key);
            $flag = preg_replace("/[0-9]+/", "", $flag);
            if ($flag == "ir" || $flag == "us" || $flag == "fr" || $flag == "de") {
                if (is_numeric($value[0]["time"])) {
                    $status = "Online";
                } else {
                    $status = "Filter";
                }
                $data[] = [
                    "flag" => $flag,
                    "status" => $status
                ];
            }
        }
        $data = json_decode(json_encode($data));
        return view('dashboard.filtering', compact('data'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Servers;
use App\Models\Traffic;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;

class FixerController extends Controller
{

    public function cronexp()
    {


        $users = Users::where('status', 'active')->get();
        foreach ($users as $us) {
            if (!empty($us->end_date)) {
                $expiredate = strtotime(date("Y-m-d", strtotime($us->end_date)));
                if ($expiredate < strtotime(date("Y-m-d")) || $expiredate == strtotime(date("Y-m-d"))) {
                    $username=$us->username;
                    $check_user = Users::where('username', $username)->get();
                    $server = Servers::where('id', $check_user[0]->server)->get();
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

                    if ($response['message'] == 'User Deleted' OR $response['message'] == 'Not Exist User') {
                        Users::where('username', $us->username)
                            ->update(['status' => 'expired']);
                    }
                }
            }
        }

        $users = Users::all();
        foreach ($users as $us) {
            $traffic = Traffic::where('username', $us->username)->get();
            foreach ($traffic as $usernamet)
            {
                $total=$usernamet->total;

                if ($us->traffic < $total && !empty($us->traffic) && $us->traffic > 0) {
                    $username=$us->username;
                    $check_user = Users::where('username', $username)->get();
                    $server = Servers::where('id', $check_user[0]->server)->get();
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

                    if ($response['message'] == 'User Deleted' OR $response['message'] == 'Not Exist User') {
                        Users::where('username', $us->username)
                            ->update(['status' => 'traffic']);
                    }


                }
            }

        }
        $this->synstraffics();
    }


    public function synstraffics()
    {
        $users = Users::where('status', 'active')->get();
        foreach ($users as $us) {
            $server = Servers::where('id', $us->server)->get();
            $ch = curl_init($server[0]->link . '/api/' . $server[0]->token . '/online');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $response = json_decode($response, true);
            curl_close($ch);
            if ($httpCode == 200 and !empty($response[0]['username'])) {
                $total=$response[0]['traffics']['total'];
                Traffic::where('username', $response[0]['username'])->update(['download' => '0', 'upload' => '0', 'total' => $total]);

            }
        }
    }


}

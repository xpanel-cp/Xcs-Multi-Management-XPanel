<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use App\Models\Packages;
use App\Models\Servers;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PackagesController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admins');
    }
    public function check()
    {
        $user = Auth::user();
        $check_admin = Admins::where('id', $user->id)->get();
        if($check_admin[0]->permission=='reseller')
        {
            exit(view('access'));
        }
    }
    public function index()
    {
        $this->check();
        $packages = Packages::all();
        $servers = Servers::all();

        return view('dashboard.package', compact('packages','servers'));
    }

    public function insert(Request $request)
    {
        $this->check();
        $request->validate([
            'title'=>'required|string',
            'amount'=>'required|string',
            'day'=>'required|string',
            'multi'=>'required|string',
            'serverid'=>'required|string',
            'multiuser'=>'required|string',
            'traffic'=>'required|string'
        ]);
        Packages::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'day' => $request->day,
            'multi' => $request->multi,
            'server' => $request->serverid,
            'traffic' => $request->traffic,
            'multiuser' => $request->multiuser
        ]);

        return redirect()->intended(route('package'));
    }
    public function edit(Request $request,$id)
    {
        $this->check();
        if (!is_numeric($id)) {
            abort(400, 'Not Valid ID');
        }
        $package = Packages::where('id', $id)->get();
        $servers = Servers::all();
        return view('dashboard.edit.package', compact('package','servers'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'id'=>'required|int',
            'title'=>'required|string',
            'amount'=>'required|string',
            'day'=>'required|string',
            'multi'=>'required|string',
            'serverid'=>'required|string',
            'multiuser'=>'required|string',
            'traffic'=>'required|string'
        ]);
        Packages::where('id', $request->id)->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'day' => $request->day,
            'multi' => $request->multi,
            'server' => $request->serverid,
            'traffic' => $request->traffic,
            'multiuser' => $request->multiuser
        ]);

        return redirect()->intended(route('package'));
    }
    public function delete(Request $request,$id)
    {
        $this->check();
        if (!is_numeric($id)) {
            abort(400, 'Not Valid Username');
        }
        Packages::where('id', $id)->delete();
        return redirect()->intended(route('package'));
    }


}

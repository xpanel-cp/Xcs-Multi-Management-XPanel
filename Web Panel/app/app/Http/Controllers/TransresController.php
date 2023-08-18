<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransRess;
class TransresController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admins');
    }
    public function index()
    {
        $user = Auth::user();

        if($user->permission=='admin')
        {
            $invoices = Transress::orderBy('id', 'desc')->get();
        }
        else{
            $invoices = Transress::where('username_trans', $user->username)->orderby('id', 'desc')->get();
        }
        return view('invoice', compact('invoices'));
    }
}

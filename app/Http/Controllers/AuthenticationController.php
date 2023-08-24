<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class AuthenticationController extends Controller {
  public function login(Request $request) 
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if (!Auth::attempt($credentials)) {
      return response()->json(['Not Authorized'], Response::HTTP_UNAUTHORIZED);
    } else {
      return response()->json(Auth::user());
    }
  }
}
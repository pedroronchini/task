<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller {
  public function index() {
    $users = User::all();

    return response()->json($users);
  }

  public function store(Request $request) {
    $data = $request->validate([
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $user = User::create($data);
    return response()->json($user, Response::HTTP_CREATED);
  }

  public function destroy($id) {
    $user = User::findOrFail($id);
    $user->delete();
    return response()->json(null, Response::HTTP_NO_CONTENT);
  }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
  public function index()
  {
    $tasks = DB::table('users')->get();
    echo json_encode($tasks);
  }

  public function create()
  {
    echo 'create';
  }

  public function store(Request $request)
  {
    if (!isset($request->name, $request->email, $request->password)) {
      return array(
        'created' => false
      );
    }

    $name = $request->name;
    $email = $request->email;
    $password = bcrypt($request->password);
    if (DB::table('users')
      ->insert(['name' => $name, 'email' => $email, 'password' => $password])) {
      return array(
        'created' => true
      );
    } else {
      return array(
        'created' => false
      );
    }
  }

  public function show($id)
  {
    $users = DB::table('users')->where('id', '=', $id)->get();
    if (sizeof($users) == 1) {
      return json_encode($users[0]);
    }
    else {
      abort(404);
    }
  }

  public function showTasks($id)
  {
    $tasks = DB::table('tasks')->where('user_id', '=', $id)->get();
    if (sizeof($tasks) >= 1) {
      return json_encode($tasks);
    }
    else {
      abort(404);
    }
  }

  public function edit($id)
  {
    echo 'edit';
  }

  public function update(Request $request, $id)
  {
    if (!isset($request->name, $request->email, $request->password)) {

      return array(
        'updated' => false
      );
    }

    $users = DB::table('users')->where('id', '=', $id)->get();
    if (sizeof($users) == 0) {
      abort(404);
    }

    $name = $request->name;
    $email = $request->email;
    $password = bcrypt($request->password);

    if (DB::table('users')->where('id', $id)
      ->update(['name' => $name, 'email' => $email, 'password' => $password])) {
      return array(
        'updated' => true
      );
    } else {
      return array(
        'updated' => false
      );
    }
  }

  public function destroy($id)
  {
    $tasks = DB::table('users')->where('id', '=', $id)->get();
    if (sizeof($tasks) == 0) {
      abort(404);
    }

    if (DB::table('users')->where('id', $id)->delete()) {
      return array(
        'deleted' => true
      );
    } else {
      return array(
        'deleted' => false
      );
    }
  }
}

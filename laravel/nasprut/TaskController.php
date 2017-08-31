<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TaskController extends Controller
{
  public function index()
  {
    $tasks = DB::table('tasks')->get();
    echo json_encode($tasks);
  }

  public function create()
  {
    echo 'create';
  }

  public function store(Request $request)
  {
    if (!isset($request->name, $request->description, $request->status, $request->user_id, $request->project_id)) {
      return array(
        'created' => false
      );
    }

    $name = $request->name;
    $description = $request->description;
    $status = $request->status;
    $user_id = $request->user_id;

    if (DB::table('tasks')
      ->insert(['name' => $name, 'description' => $description, 'status' => $status, 'user_id' => $user_id, 'project_id' => $request->project_id])) {
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
    $tasks = DB::table('tasks')->where('id', '=', $id)->get();
    if (sizeof($tasks) == 1) {
      return json_encode($tasks[0]);
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
    if (!isset($request->name, $request->description, $request->status, $request->user_id, $request->project_id)) {
      return array(
        'updated' => false
      );
    }

    $tasks = DB::table('tasks')->where('id', '=', $id)->get();
    if (sizeof($tasks) == 0) {
      abort(404);
    }

    $name = $request->name;
    $description = $request->description;
    $status = $request->status;
    $user_id = $request->user_id;

    if (DB::table('tasks')->where('id', $id)
      ->update(['name' => $name, 'description' => $description, 'status' => $status, 'user_id' => $user_id, 'project_id' => $request->project_id])) {
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
    $tasks = DB::table('tasks')->where('id', '=', $id)->get();
    if (sizeof($tasks) == 0) {
      abort(404);
    }

    if (DB::table('tasks')->where('id', $id)->delete()) {
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

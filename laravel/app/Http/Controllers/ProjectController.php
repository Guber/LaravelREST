<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProjectController extends Controller
{
  public function index()
  {
    $projects = DB::table('projects')->get();
    echo json_encode($projects);
  }

  public function create()
  {
    echo 'create';
  }

  public function store(Request $request)
  {
    if (!isset($request->name, $request->description)) {
      return array(
        'created' => false
      );
    }

    $name = $request->name;
    $description = $request->description;

    if (DB::table('projects')
      ->insert(['name' => $name, 'description' => $description])) {
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
    $tasks = DB::table('projects')->where('id', '=', $id)->get();
    if (sizeof($tasks) == 1) {
      return json_encode($tasks[0]);
    }
    else {
      abort(404);
    }
  }

  public function showTasks($id)
  {
    $tasks = DB::table('tasks')->where('project_id', '=', $id)->get();
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
    if (!isset($request->name, $request->description)) {
      return array(
        'updated' => false
      );
    }

    $tasks = DB::table('projects')->where('id', '=', $id)->get();
    if (sizeof($tasks) == 0) {
      abort(404);
    }

    $name = $request->name;
    $description = $request->description;

    if (DB::table('projects')->where('id', $id)
      ->update(['name' => $name, 'description' => $description])) {
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
    $tasks = DB::table('projects')->where('id', '=', $id)->get();
    if (sizeof($tasks) == 0) {
      abort(404);
    }

    if (DB::table('projects')->where('id', $id)->delete()) {
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

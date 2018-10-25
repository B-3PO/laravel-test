<?php

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

Route::group(['middleware' => ['api']], function () {

  Route::get('/tasks', function () {
    try {
      $tasks = Task::orderBy('created_at', 'asc')->get();
      return response()->json([
        'status' => 'success',
        'tasks' => $tasks,
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => 'Error',
        'message' => $e->getMessage(),
      ], 409);
    }
  });

  Route::post('/task', function (Request $request) {
    try {
      $task = new Task;
      $task->name = $request->name;
      $task->save();

      return response()->json([
        'status' => 'success',
        'task' => $task,
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => 'Error',
        'message' => $e->getMessage(),
      ], 409);
    }
  });

  Route::post('/task/{id}/delete', function ($id) {
    try {
      Task::findOrFail($id)->delete();
      return response()->json([
        'status' => 'success',
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'status' => 'Error',
        'message' => $e->getMessage(),
      ], 409);
    }
  });

});

<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class TodoController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = FacadesJWTAuth::parseToken()->authenticate();
    }

    public function getTodoList()
    {
        return $this->user->todos()->get(['title'])->toArray();
    }

    public function showTodo($id)
    {
        $todo = $this->user->todos()->find($id);
    
        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo with name ' . $id . ' cannot be found'
            ], 400);
        }
    
        return $todo;
    }

    public function addTodo(Request $request)
    {
        $this->validate($request, ['title' => 'required']);
    
        $todo = new Todo();
        $todo->title = $request->title;
    
        if ($this->user->todos()->save($todo))
            return response()->json([
                'success' => true,
                'todo' => $todo
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $todo = $this->user->todos()->find($id);
    
        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo with name ' . $id . ' cannot be found'
            ], 400);
        }
    
        $updated = $todo->fill($request->all())->save();
    
        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo could not be updated'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $todo = $this->user->todos()->find($id);
    
        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, todo with name ' . $id . ' cannot be found'
            ], 400);
        }
    
        if ($todo->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Todo could not be deleted'
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{

    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $todos = Todo::with('user')
            ->where('user_id', $user->id)
            ->get();

        return $this->apiSuccess($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $request->validated();

        $user = auth()->user();
        $category = Category::find($request->category_id);
        $todo = new Todo($request->all());
        $todo->user()->associate($user);
        $todo->category()->associate($category);
        $todo->save();                

        return $this->apiSuccess($todo->load('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return $this->apiSuccess($todo->load('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $request->validated();
        $todo->name = $request->name;
        $todo->description = $request->description;
        $todo->due_date = $request->due_date;
        $todo->due_time = $request->due_time;
        $todo->category_id = $request->category_id;        
        $todo->save();
        return $this->apiSuccess($todo->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->delete();
            return $this->apiSuccess($todo);
        }
        return $this->apiError(
            'Unauthorized',
            Response::HTTP_UNAUTHORIZED
        );
    }
}

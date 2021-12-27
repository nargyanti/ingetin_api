<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Validator;

class TodoRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->method() == Request::METHOD_POST)
            return true;
        $todo = $this->route('todo');
        return auth()->user()->id == $todo->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [            
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'due_date' => 'required|date',
            'due_time' => 'required',            
            'category_id' => 'nullable|integer',
            'is_done' => 'nullable|boolean',
        ];
    }
}

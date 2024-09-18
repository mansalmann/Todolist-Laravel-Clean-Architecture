<?php

namespace App\Http\Requests;

use App\Services\TodolistService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function __construct(private TodolistService $todolistService){}
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "todo" => ["required"]
        ];
    }

    protected function failedValidation(Validator $validator){
        $todolist = $this->todolistService->getTodolist();
        throw new HttpResponseException(response()->view("todolist.todolist",[
            "title" => "Todolist",
            "todolist" => $todolist,
            "error" => "Todo harus diisi"
        ]));
    }

    
}

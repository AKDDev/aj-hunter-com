<?php

namespace App\Http\Requests\Goals;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:goals,id',
            'goal' => 'required|string',
            'project_id' => 'required|integer|exists:projects,id',
            'status_id' => 'required|integer|exists:statuses,id',
            'total' => 'required|integer',
            'type_id' => 'required|integer|exists:types,id',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
        ];
    }
}

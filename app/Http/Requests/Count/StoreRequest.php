<?php

namespace App\Http\Requests\Count;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'goal_id' => 'required|integer|exists:goals,id',
            'value' => 'required|integer|min:1',
            'when' => 'required|date',
            'comment' => 'nullable|string',
        ];
    }
}

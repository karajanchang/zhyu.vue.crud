<?php

namespace ZhyuVueCurd\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolePermissionSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !empty(auth()->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'resource_id' => 'required|array',
        ];
    }
}

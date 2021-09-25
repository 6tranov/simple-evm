<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DateOrder;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
     /*
    public function authorize()
    {
        return false;
    }
    */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $dateOrder1 = new DateOrder();
        $dateOrder2 = new DateOrder();
        return [
            //
            'task.name' => 'required|string|min:1|max:100',
            'task.start_scheduled_on' => ['required','date',$dateOrder1],
            'task.complete_scheduled_on' => ['required','date',$dateOrder1],
            'task.started_on' => ['nullable','date',$dateOrder2],
            'task.completed_on' => ['nullable','date',$dateOrder2],
            'task.planned_value' => 'required|integer|min:1',
            'task.earned_value' => 'nullable|integer|min:0',
            'task.actual_cost' => 'nullable|integer|min:0'
        ];
    }
}

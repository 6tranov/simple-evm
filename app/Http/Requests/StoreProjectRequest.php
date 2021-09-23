<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DateOrder;

class StoreProjectRequest extends FormRequest
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
        $dateOrder = new DateOrder();
        return [
            //
            'project.name' => 'required|string|min:1|max:100',
            'project.start_scheduled_on' => ['required', 'date', $dateOrder],
            'project.complete_scheduled_on'=> ['required', 'date', $dateOrder],
            'project.time_per_day'=>'required|integer|min:1|max:86400',
            'project.total_cost'=>'required|integer|min:1|max:10000'
        ];
    }
}

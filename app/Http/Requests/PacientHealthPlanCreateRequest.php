<?php

namespace App\Http\Requests;

use App\Models\PacientHealthPlan;
use App\Rules\CompositeUnique;

class PacientHealthPlanCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = PacientHealthPlan::$rules;

        $rules['pacient_id'] = ['required', new CompositeUnique('pacient_health_plan', [
            'pacient_id' => $this->input('pacient_id'),
            'health_plan_id' => $this->input('health_plan_id')
        ])];

        return $rules;
    }
}

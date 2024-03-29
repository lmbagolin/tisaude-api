<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Rules\CompositeUnique;
use Illuminate\Support\Facades\DB;

class AppointmentCreateRequest extends FormRequest
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
        $rules = Appointment::$rules;

        $dateRule = new CompositeUnique('appointment', [
            'pacient_id' => $this->input('pacient_id'),
            'date' => DB::raw("DATE_FORMAT('" . $this->input('date') . "', '%Y-%m-%d')")
        ]);
        $dateRule->customMessage = "The patient already has an appointment on the scheduled date.";

        $rules['date'][] = $dateRule;
        return $rules;
    }
}

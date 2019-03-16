<?php

namespace App\Http\Requests\Backend\Parking;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateAppointmentRequest.
 */
class UpdateParkingRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return $this->user()->isAdmin();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'status'     => ['boolean'],
			'capacity'     => ['required', 'max:191', 'integer'],
			'price'     => ['required', 'max:191', 'integer'],
			'latitude'     => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
			'longitude'     => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
		];
	}
}

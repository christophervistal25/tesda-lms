<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class CreateBadgeRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'empty_array',
            function ($attribute, $value, $parameters) {
                dd(is_null($value));
                return is_null($value);
            },
            'Criteria is required'
        );
    }

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
        return [
            'badge_name'        => 'required',
            'badge_description' => 'required',
            'criteria'          => 'required'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Support\Str;

class CreateModuleRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'file_content',
            function ($attribute, $value, $parameters) {
               return Str::contains($value, ['.doc', '.docx', '.txt', '.ppt', '.pptx', '.pdf']);
            },
            'Please check the content of download activity if there\'s an file attach to it.'
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
        $rules = [
            'title'                                => 'required',
            'body'                                 => 'required',
            'activity_no.*'                        => 'required',
            'activity_name.*'                      => 'required',
            'activity_instructions.*'              => 'required',
            'activity_icon.*'                      => 'required',
            'activity_content.*'                   => 'required',
            'downloadable_activity_no.*'           => 'required',
            'downloadable_activity_name.*'         => 'required',
            'downloadable_activity_icon.*'         => 'required',
            'downloadable_activity_instructions.*' => 'required',
            'downloadable_activity_content.*'      => 'required|file_content',
            'completion_activity_no.*'             => 'required',
            'completion_activity_name.*'           => 'required',
            'completion_activity_icon.*'           => 'required',
            'completion_activity_content.*'        => 'required',
        ];
        
        return $rules;
    }

    public function messages()
    {
        return [
                'downloadable_activity_name.*.required'         => 'Downloadable activity name is required',
                'downloadable_activity_no.*.required'           => 'Downloadable activity number is required',
                'downloadable_activity_instructions.*.required' => 'Downloadable activity instructions is required',
                'downloadable_activity_content.*.required'      => 'Downloadable activity content is required',
                'downloadable_activity_icon.*.required'         => 'Please select activity icon',
                
                'activity_name.*.required'                      => 'Activity name is required',
                'activity_no.*.required'                        => 'Activity number is required',
                'activity_instructions.*.required'              => 'Activity instructions is required',
                'activity_content.*.required'                   => 'Activity content is required',
                'activity_icon.*.required'                      => 'Please select activity icon',
                
                'completion_activity_name.*.required'           => 'Completion activity name is required',
                'completion_activity_no.*.required'             => 'Completion activity number is required',
                'completion_activity_instructions.*.required'   => 'Completion activity instructions is required',
                'completion_activity_content.*.required'        => 'Completion activity content is required',
                'completion_activity_icon.*.required'           => 'Please select activity icon',
        ];
    }
}


<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class CreateFinalExamRequest extends FormRequest
{

    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'choices_content',
            function ($attribute, $value, $parameters) {
                $error = 0;
                foreach ($value as $choice) {
                    list($choiceLetter, $value) = explode('.', $choice);
                     if (strlen($value) == 0) {
                         return false;
                     }
                }
            },
            'did you forgot to add a text for choices?'
        );

        $validationFactory->extend(
            'correct_answer_content',
            function ($attribute, $value, $parameters) {
                list($choiceLetter, $value) = explode('.', $value);
                return !empty($value);
            },
            'check the correct answer'
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
        $rules =  [
            'multipleChoice.*.question'       => 'required',
            'multipleChoice.*.choices'        => ['required', ''],
            'multipleChoice.*.correct_answer' => ['required', 'correct_answer_content'],
            'fillIntheBlank.*.question'       => 'required',
            'fillIntheBlank.*.correct_answer' => 'required',
            'trueOrFalse.*.question'          => 'required',
            'trueOrFalse.*.correct_answer'    => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'multipleChoice.*.question.required'       => 'field is required',
            'multipleChoice.*.correct_answer.required' => 'correct answer is required',
            'multipleChoice.*.choices.required'        => 'choices is required',
            'fillIntheBlank.*.question.required'       => 'field is required',
            'fillIntheBlank.*.correct_answer.required' => 'correct answer is required',
            'trueOrFalse.*.question.required'          => 'field is required',
            'trueOrFalse.*.correct_answer.required'    => 'correct answer is required',

        ];
    }

    public function attributes()
    {
        return [
            'multipleChoice.*.question' => 'question',
            'multipleChoice.*.correct_answer' => 'correct answer',
            'multipleChoice.*.choices' => 'choices',
            'fillIntheBlank.*' => 'Fill in the blank',
            'trueOrFalse.*' => 'True or False',
        ];
    }
}

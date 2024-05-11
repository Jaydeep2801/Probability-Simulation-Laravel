<?php

namespace App\Http\Requests;

use App\Models\Prize;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxProbability;

class PrizeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('prize') ? $this->route('prize')->id : null;

        return [
            'title' => 'required',
            'probability' => [
                'required',
                'numeric',
                'min:0',
                new MaxProbability( $id )
            ],
        ];
    }
}

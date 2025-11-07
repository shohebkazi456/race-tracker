<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCheckpointRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->is_admin ?? false; }
    public function rules(): array {
        return [
            'race_id'=>'required|exists:races,id',
            'checkpoint_name'=>'required|string|max:255',
            'order_no'=>[
                'required','integer','min:1',
                Rule::unique('race_checkpoints','order_no')->where('race_id', $this->race_id),
            ],
        ];
    }
}

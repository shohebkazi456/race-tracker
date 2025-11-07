<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRaceRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->is_admin ?? false; }
    public function rules(): array {
        return ['race_name'=>'required|string|max:255|unique:races,race_name','description'=>'nullable|string'];
    }
}

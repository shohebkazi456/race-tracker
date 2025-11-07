<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->is_admin ?? false; }
    public function rules(): array { return ['team_name'=>'required|string|max:255|unique:teams,team_name']; }
    
}
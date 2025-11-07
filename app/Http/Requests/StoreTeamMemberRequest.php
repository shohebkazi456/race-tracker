<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamMemberRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->is_admin ?? false; }
    public function rules(): array {
        return [
            'team_id'=>'required|exists:teams,id',
            'member_name'=>[
                'required','string','max:255',
                Rule::unique('team_members','member_name')->where('team_id', $this->team_id),
            ],
            'race_id'=>'nullable|exists:races,id',
        ];
    }
}

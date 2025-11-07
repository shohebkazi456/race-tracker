<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRaceLogRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }
    public function rules(): array {
        return [
            'race_id'=>'required|exists:races,id',
            'member_id'=>'required|exists:team_members,id',
            'checkpoint_id'=>'required|exists:race_checkpoints,id',
            'reached_at'=>'required|date',
        ];
    }
}
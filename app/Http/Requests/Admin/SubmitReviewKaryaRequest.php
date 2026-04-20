<?php

namespace App\Http\Requests\Admin;

use App\Enums\KaryaStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitReviewKaryaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $karyaSeni = $this->route('karyaSeni');

        return $this->user()?->can('review', $karyaSeni) ?? false;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(KaryaStatus::reviewOutcomes())],
            'catatan_review' => ['required', 'string'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIssueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Issue::class);
    }

    public function rules(): array
    {
        return [
            'project_id' => [
                'required',
                'uuid',
                'exists:projects,id',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $project = Project::query()->find($value);

                    if (! $project || $project->owner_id !== $this->user()->id) {
                        $fail(__('You may only create issues on your own projects.'));
                    }
                },
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::enum(IssueStatus::class)],
            'priority' => ['required', Rule::enum(IssuePriority::class)],
            'due_date' => ['nullable', 'date'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIssueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('issue'));
    }

    public function rules(): array
    {
        $issue = $this->route('issue');

        return [
            'project_id' => [
                'required',
                'uuid',
                'exists:projects,id',
                function (string $attribute, mixed $value, \Closure $fail) use ($issue): void {
                    $project = Project::query()->find($value);

                    if (! $project) {
                        return;
                    }

                    if ($project->owner_id === $this->user()->id) {
                        return;
                    }

                    if ($issue->members()->whereKey($this->user()->id)->exists() && $value === $issue->project_id) {
                        return;
                    }

                    $fail(__('You may not move this issue to the selected project.'));
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

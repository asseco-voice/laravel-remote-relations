<?php

namespace Asseco\RemoteRelations\App\Http\Requests;

use Asseco\RemoteRelations\App\Contracts\RemoteRelationType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RemoteRelationTypeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $type = $this->route('remote_relation_type');
        $name = $this->name;

        return [
            'name'          => [
                'required',
                'string',
                Rule::unique('remote_relation_types')->ignore($this->$type)->where(function ($query) {
                    return $this->usesSoftDelete() ? $query->whereNull('deleted_at') : $query;
                }),
            ],
            'label'         => 'required|string',
            'inverse_name'  => 'required|string',
            'inverse_label' => 'required|string',
        ];
    }

    private function usesSoftDelete(): bool
    {
        return in_array(SoftDeletes::class, class_uses_recursive(app(RemoteRelationType::class)));
    }
}

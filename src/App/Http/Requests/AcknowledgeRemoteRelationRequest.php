<?php

namespace Asseco\RemoteRelations\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcknowledgeRemoteRelationRequest extends FormRequest
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
        return [
            'service' => 'required|string',
            'model' => 'required|string',
            'id' => 'required',
            'remote_id' => 'nullable|string',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferenciaRequest extends FormRequest
{
    /**
     * Determine se o usuário tem permissão para fazer esta solicitação.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Podemos adicionar verificações de autorização aqui, se necessário.
    }

    /**
     * Obtenha as regras de validação que devem ser aplicadas à solicitação.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'origem_conta_id' => 'required|exists:conta,conta_id',
            'destino_conta_id' => 'required|exists:conta,conta_id|different:origem_conta_id',
            'valor' => 'required|numeric|min:0.1',
        ];
    }

    /**
     * Obtenha as mensagens de erro personalizadas para as validações.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'origem_conta_id.required' => 'A conta de origem é obrigatória.',
            'destino_conta_id.required' => 'A conta de destino é obrigatória.',
            'valor.required' => 'O valor da transferência é obrigatório.',
            'valor.numeric' => 'O valor da transferência deve ser numérico.',
            'valor.min' => 'O valor da transferência deve ser maior que zero.',
            'destino_conta_id.different' => 'A conta de origem não pode ser a mesma da conta de destino.',
            'origem_conta_id.exists' => 'A conta de origem não foi encontrada.',
            'destino_conta_id.exists' => 'A conta de destino não foi encontrada.',
        ];
    }
}


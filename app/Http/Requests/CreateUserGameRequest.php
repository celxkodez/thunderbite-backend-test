<?php

namespace App\Http\Requests;

use App\Models\Game;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $game = Game::where('account', request('a'))->latest('created_at')->first();

        if ($game && $game->created_at->istoday()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'a' => ['required', 'string'],
            'spin' => ['required', 'numeric'],
            'start_date' => ['string'],
            'end_date' => ['string'],
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException('Games Creation has been exceeded for selected User');
    }
}

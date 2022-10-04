<?php

namespace App\Http\Requests;

use App\Models\Game;
use App\Models\SymbolId;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class GameLauchRequest extends FormRequest
{
    public $authorizationFailedMessage = 'Sorry You Are Not Allowed';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $account = request('a');

        if (!$account) {
            $url = url("/?a=username");
            $this->authorizationFailedMessage = "User Account Is Required: should look like {$url}";

            return false;
        }

        $game = Game::where('account', $account)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->latest('created_at')
            ->first();

        //dd($game);
        if (!$game) {
            $this->authorizationFailedMessage = "there is no available game for you at this moment";
            return false;
        }

        $symbolsId = SymbolId::count();

        $symbolsIdNumberCheck = $symbolsId > 10 ? "Must Be less than 10"
            : ($symbolsId < 6 ? "Must be Greater than 6" : "");

        if ($symbolsIdNumberCheck !== "") {
            $this->authorizationFailedMessage = "Symbols Ids $symbolsIdNumberCheck";
            return false;
        }

        //dd($symbolsId);
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
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
        throw new AuthorizationException($this->authorizationFailedMessage);
    }
}

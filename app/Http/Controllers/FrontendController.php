<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserGameRequest;
use App\Http\Requests\GameLauchRequest;
use App\Models\Campaign;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function loadCampaign(CreateUserGameRequest $request,Campaign $campaign)
    {
        $data = $request->validated();

        //dd(request());
        //dd($request->all());
        return view('frontend.index');
    }

    public function createGame(Request $request,Campaign $campaign)
    {
        $data = $this->validate($request, [
            'account' => ['required', 'string'],
            'spin' => ['required', 'numeric'],
            'start_date' => ['required'],
            'end_date' => ['required'],
        ]);

        $data = [
            'account' => $data['account'],
            'spin' => $data['spin'],
            'campaign_id' => $campaign->id,
            'starts_at' => Carbon::parse($data['start_date']),
            'ends_at' => Carbon::parse($data['end_date']),
        ];

        $game = Game::create($data);

        return redirect("/?a={$data['account']}")->with('success', 'Games Created!');
    }


    public function placeholder(GameLauchRequest $request)
    {
        return view('frontend.placeholder');
    }
}

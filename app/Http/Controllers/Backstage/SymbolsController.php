<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\SymbolId;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SymbolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('backstage.symbols.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backstage.symbols.create', [
            'symbol' => new SymbolId(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validation
        $data = $this->validate($request, [
            'name' => ['required', 'unique:symbol_ids', 'max:255'],
            'match_point_3' => ['required'],
            'match_point_4' => ['required'],
            'match_point_5' => ['required'],
            'image' => ['required', 'image']
        ]);

        $imageFileName = Str::random(9) . '_' . $data['image']->getClientOriginalName();

        $dir = 'img/symbols-images/';

        $data['image']->move($dir, $imageFileName);

        unset($data['image']);

        $data['image_url'] = $dir . $imageFileName;

        SymbolId::create($data);

        // Set message
        session()->flash('success', 'The Symbol has been created!');

        // Redirect
        return redirect()->route('backstage.symbols.index');
    }
}

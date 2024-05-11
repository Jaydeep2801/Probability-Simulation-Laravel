<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Prize;
use App\Http\Requests\PrizeRequest;
use Illuminate\Http\Request;

class PrizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $prizes = Prize::all();

        return view('prizes.index', ['prizes' => $prizes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('prizes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PrizeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PrizeRequest $request)
    {
        Prize::create($request->validated());

        return to_route('prizes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $prize = Prize::findOrFail($id);
        return view('prizes.edit', ['prize' => $prize]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PrizeRequest  $request
     * @param  Prize  $prize
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PrizeRequest $request, Prize $prize)
    {
        $prize->update($request->validated());

        return to_route('prizes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $prize = Prize::findOrFail($id);
        $prize->delete();

        return to_route('prizes.index');
    }

    /**
     * Allots the prizes.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function simulate(Request $request)
    {

        $number_of_prizes = $request->number_of_prizes ?? 10;
        for ($i = 0; $i < $number_of_prizes; $i++) {
            Prize::nextPrize($number_of_prizes);
        }

        return to_route('prizes.index');
    }

    /**
     * Resets the alloted prizes.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset()
    {
        Prize::query()->update(['alloted' => 0 ]);
        return to_route('prizes.index');
    }
}

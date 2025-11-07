<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRaceRequest;
use App\Models\Race;

class RaceController extends Controller
{
    public function __construct(){  $this->middleware(['auth', \App\Http\Middleware\EnsureAdmin::class]); }

    public function index(){ $races = Race::withCount('checkpoints')->paginate(10); return view('admin.races.index', compact('races')); }
    public function create(){ return view('admin.races.create'); }
    public function store(StoreRaceRequest $req){ Race::create($req->validated()); return redirect()->route('admin.races.index')->with('ok','Race created'); }
    public function edit(Race $race){ return view('admin.races.edit', compact('race')); }
    public function update(StoreRaceRequest $req, Race $race){ $race->update($req->validated()); return back()->with('ok','Updated'); }
    public function destroy(Race $race){ $race->delete(); return back()->with('ok','Deleted'); }
}
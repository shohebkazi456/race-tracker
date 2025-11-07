<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckpointRequest;
use App\Models\{Race, RaceCheckpoint};

class RaceCheckpointController extends Controller
{
    public function __construct(){  $this->middleware(['auth', \App\Http\Middleware\EnsureAdmin::class]); }

    public function index(Race $race){
        $checkpoints = $race->checkpoints()->get();
        return view('admin.checkpoints.index', compact('race','checkpoints'));
    }
    public function create(Race $race){ return view('admin.checkpoints.create', compact('race')); }
    public function store(StoreCheckpointRequest $req, Race $race){
        RaceCheckpoint::create($req->validated());
        return redirect()->route('admin.races.checkpoints.index', $race)->with('ok','Checkpoint added');
    }
    public function edit(Race $race, RaceCheckpoint $checkpoint){ return view('admin.checkpoints.edit', compact('race','checkpoint')); }
    public function update(StoreCheckpointRequest $req, Race $race, RaceCheckpoint $checkpoint){
        $checkpoint->update($req->validated());
        return back()->with('ok','Updated');
    }
    public function destroy(Race $race, RaceCheckpoint $checkpoint){
        $checkpoint->delete();
        return back()->with('ok','Deleted');
    }
}
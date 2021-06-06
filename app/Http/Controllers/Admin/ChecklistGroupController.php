<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChecklistGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChecklistGroupRequest;
use App\Http\Requests\UpdateChecklistGroupRequest;

class ChecklistGroupController extends Controller
{
    public function create()
    {
        return view('admin.checklist_group.create');
    }

    public function store(StoreChecklistGroupRequest $request)
    {
        ChecklistGroup::create($request->validated());

        return redirect()->route('home');
    }

    public function edit(ChecklistGroup $checklistGroup)
    {
        return view('admin.checklist_group.edit', compact('checklistGroup'));
    }

    public function update(UpdateChecklistGroupRequest $request, ChecklistGroup $checklistGroup)
    {
        $checklistGroup->update($request->validated());

        return redirect()->route('home');
    }

    public function destroy(ChecklistGroup $checklistGroup)
    {
        $checklistGroup->delete();

        return redirect()->route('home');
    }
}

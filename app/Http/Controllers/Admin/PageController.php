<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdatePageRequest;

class PageController extends Controller
{
    public function edit(Page $page) : View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page) : RedirectResponse
    {
        $page->update($request->validated());

        return redirect()->route('admin.pages.edit', $page)->with('message', __('Page updated successfully.'));
    }
}

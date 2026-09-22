<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkillRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SkillController extends Controller
{
    public function index(): Response
    {
        $skills = Skill::orderBy('sort_order')->orderBy('name')->get();

        return Inertia::render('Admin/Skills/Index', [
            'skills' => $skills,
        ]);
    }

    public function store(SkillRequest $request): RedirectResponse
    {
        Skill::create($request->validated());

        return back()->with('status', 'Skill added successfully.');
    }

    public function update(SkillRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());

        return back()->with('status', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return back()->with('status', 'Skill removed successfully.');
    }
}

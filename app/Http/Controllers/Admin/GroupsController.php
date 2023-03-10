<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GroupsController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super-admin');

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny-group');

        $groups = Group::withCount('users')->latest()->paginate(12);

        return view('groups.index')
                ->with('groups', $groups);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {   
        $this->authorize('create-group');

        return view('groups.create')
                ->with('group', new Group);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create-group');

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'sometimes'
        ]);

        $group = Group::create($validated);


        return redirect()->route('admin.groups.index')->with('success', 'Group created successfully');
    } 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group): View
    {
       Gate::authorize('update-group', $group);

        return view('groups.create')
            ->with('group', $group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        Gate::allowIf(fn (User $user) => $user->hasRole('super-admin'), 'Not Found', 404);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'sometimes'
        ]);

        $group = $group->fill($validated)->save();


        return redirect()->route('admin.groups.index')->with('success', 'Group updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete-group', $group);

        $group->delete();
        return redirect()->back()->with('success', 'Group deleted successfully');
    }
}

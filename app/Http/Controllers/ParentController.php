<?php

namespace App\Http\Controllers;

use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('parent');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('profession', 'like', "%{$s}%")
                  ->orWhere('address', 'like', "%{$s}%");
            });
        }

        $parents = $query->orderBy('name')->get();

        // Attach student children info to each parent
        foreach ($parents as $p) {
            $p->children = DB::table('student')
                ->where('parent_id', $p->parent_id)
                ->select('student_id', 'name', 'photo')
                ->get();
            $p->children_count = $p->children->count();
        }

        $allParents = DB::table('parent')->get();
        $totalChildrenLinked = DB::table('student')->whereNotNull('parent_id')->count();
        $professions = DB::table('parent')
            ->whereNotNull('profession')
            ->where('profession', '!=', '')
            ->distinct()
            ->orderBy('profession')
            ->pluck('profession');
        $withContacts = DB::table('parent')->whereNotNull('phone')->where('phone', '!=', '')->count();

        $metrics = [
            'total_parents'         => $allParents->count(),
            'total_children_linked' => $totalChildrenLinked,
            'professions_count'     => $professions->count(),
            'with_contacts'         => $withContacts,
        ];

        return view("parent.index", compact('parents', 'metrics', 'professions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:parent,email',
            'phone'      => 'required|string|max:25',
            'address'    => 'nullable|string|max:500',
            'profession' => 'nullable|string|max:100',
        ]);

        DB::table('parent')->insert([
            'name'       => $request->input('name'),
            'email'      => $request->input('email'),
            'phone'      => $request->input('phone'),
            'address'    => $request->input('address'),
            'profession' => $request->input('profession'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('parents.index')->with('success', 'Parent registered successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentModel $parentModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:parent,email,' . $id . ',parent_id',
            'phone'      => 'required|string|max:25',
            'address'    => 'nullable|string|max:500',
            'profession' => 'nullable|string|max:100',
        ]);

        // Update the parent record in the database
        DB::table('parent')
            ->where('parent_id', $id)
            ->update([
                'name'       => $request->input('name'),
                'email'      => $request->input('email'),
                'phone'      => $request->input('phone'),
                'address'    => $request->input('address'),
                'profession' => $request->input('profession'),
                'updated_at' => now(),
            ]);

        return redirect()->route('parents.index')->with('success', 'Parent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if the parent exists
        $parent = DB::table('parent')->where('parent_id', $id)->first();
        if (!$parent) {
            return redirect()->route('parents.index')->with('error', 'Parent not found.');
        }

        // Safely detach any associated students
        DB::table('student')->where('parent_id', $id)->update(['parent_id' => null]);

        // Delete the parent
        DB::table('parent')->where('parent_id', $id)->delete();

        return redirect()->route('parents.index')->with('success', 'Parent deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        $students = $query->latest()->paginate(10);

        return view('pages.students.index', compact('students'));
    }

    public function create()
    {
        return view('pages.students.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|numeric|min:9|unique:students,nim',
            'name' => 'required|min:4',
            'is_active' => 'required|boolean',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student created successfully');
    }

    public function edit(Student $student)
    {
        return view('pages.students.form', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nim' => 'required|numeric|min:9|unique:students,nim,' . $student->id,
            'name' => 'required|min:4',
            'is_active' => 'required|boolean',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success','Student deleted successfully');
    }
}

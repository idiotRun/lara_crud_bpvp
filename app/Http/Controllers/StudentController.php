<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::latest()->get();

        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // set validate
        $request->validate([
            'name' => 'required|string',
            'photo' => 'required|image|max:2048',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'gender' => 'required|numeric',
            'address' => 'required|string'
        ]);

        // save to DB
        try {
            $fileName = uniqid() . '.' . $request->photo->getClientOriginalExtension();

            $create = new Student;
            $create->name = $request->name;
            $create->photo = $request->photo->storeAs('student', $fileName, 'public');
            $create->birth_date = Carbon::parse($request->birth_date)->format('Y-m-d');
            $create->birth_place = $request->birth_place;
            $create->gender = (int)$request->gender;
            $create->address = $request->address;
            $create->save();

            return redirect()->route('student.index')->with('success', 'Data berhasil disubmit');
        } catch (\Throwable $th) {
            return redirect()->route('student.index')->with('error', 'Data gagal disubmit');
        }
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
    public function edit(string $id)
    {
        // get by id
        $data = Student::findOrFail($id);

        return view('student.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // set validate
        $request->validate([
            'name' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string',
            'gender' => 'required|numeric',
            'address' => 'required|string'
        ]);

        // save to DB
        try {
            $update = Student::findOrFail($id);
            $update->name = $request->name;
            if($request->file('photo')) {
                // remove old img
                Storage::delete($update->photo);

                $fileName = uniqid() . '.' . $request->photo->getClientOriginalExtension();
                $update->photo = $request->photo->storeAs('student', $fileName, 'public');
            }
            $update->birth_date = Carbon::parse($request->birth_date)->format('Y-m-d');
            $update->birth_place = $request->birth_place;
            $update->gender = (int)$request->gender;
            $update->address = $request->address;
            $update->save();

            return redirect()->route('student.index')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('student.index')->with('error', 'Data gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // destroy
        $data = Student::findOrFail($id);
        if(!empty($data->photo)) {
            Storage::delete($data->photo);
        }

        if($data->delete()) {
            return redirect()->route('student.index')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('student.index')->with('error', 'Data gagal dihapus');
        }
    }
}

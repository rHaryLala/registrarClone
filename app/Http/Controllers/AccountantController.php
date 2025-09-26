<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentPayment;
use App\Models\Student;

class AccountantController extends Controller
{
    public function dashboard()
    {
        // Only include students whose academic year is active
        $students = Student::with('academicYear')
            ->whereHas('academicYear', function ($query) {
                $query->where('active', true);
            })
            ->orderByDesc('id')
            ->get();

        return view('accountant.dashboard', compact('students'));
    }

    public function updateFeeCheck(Request $request, Student $student)
    {
        // Controller is already protected by 'accountant' middleware; no extra policy check required here.
        $validated = $request->validate([
            'fee_check' => 'required|boolean',
        ]);

        $student->fee_check = $validated['fee_check'];
        $student->save();

        return response()->json(['success' => true, 'fee_check' => $student->fee_check]);
    }
}

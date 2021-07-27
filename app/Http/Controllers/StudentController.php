<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    private $newStudentValidation = [
        'name' => 'required|string|min:2|max:80',
        'last_names' => 'required|string|min:3|max:165',
        'email' => 'required|email|max:120',
        'major_id' => 'required|exists:majors,id',
        'status' => 'required|boolean',
    ];

    private $updateStudentValidation = [
        'name' => 'string|min:2|max:80',
        'last_names' => 'string|min:3|max:165',
        'email' => 'email|max:120',
        'major_id' => 'exists:majors,id',
        'status' => 'boolean',
    ];

    /**
     * Display a paginated listing of students.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $limit, int $offset = 0, $direction = 'next')
    {
        // Select fields
        $studentsQuery = Student::select(['students.id', 'students.name', 'students.last_names',
            'students.status', 'major_id', 'majors.name AS major_name'])
            ->join('majors', 'students.major_id', 'majors.id');

        // Keyset pagination
        if ($direction === 'back') {
            $studentsQuery->where('students.id', '<', $offset)->orderBy('students.id', 'desc');
        } else {
            $studentsQuery->where('students.id', '>=', $offset)->orderBy('students.id', 'asc');
        }

        // Get results
        $students = $studentsQuery->limit($limit + 1)->get();

        // Check direction
        if ($direction === 'back') {
            // Reverse to the right order
            $students = $students->reverse();

            // More results than the limit (there are more pages) before
            if (count($students) > $limit) {
                $result['next_student_id'] = $offset;
                $result['last_student_id'] = $students[$limit]->id;

                unset($students[0]);
            } else {
                // No more pages (first page)
                $result['next_student_id'] = $offset;
                $result['last_student_id'] = null;
            }

        } else {
            // More results than the limit (there are more pages) after
            if (count($students) > $limit) {
                $result['next_student_id'] = $students[$limit]->id;
                $result['last_student_id'] = $offset;

                unset($students[$limit]);
            } else {
                // No more pages (last page)
                $result['last_student_id'] = $offset;
                $result['next_student_id'] = null;
            }
        }

        // Check if last student ID is valid
        if ($result['last_student_id'] < 1) $result['last_student_id'] = null;

        $result['students'] = $students;

        // Return JSON response
        return response()->json($result);
    }

    /**
     * Show the form for creating a new student.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->newStudentValidation);

        $student = new Student($validated);

        $student->save();

        return response()->json($student, 201);
    }

    /**
     * Display the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return response()->json($student);
    }

    /**
     * Show the form for editing the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $updateStudentValidationSelf =  $this->updateStudentValidation;

        $validated = $request->validate($updateStudentValidationSelf);

        $student->update($validated);

        return response()->json($student);
    }

    /**
     * Remove the specified student from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->destroy($student->id);

        return response()->json([
            'message' => 'Student deleted successfully'
        ]);
    }
}

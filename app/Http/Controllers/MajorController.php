<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{

    private $newMajorValidation = [
        'name' => 'required|string|min:4|max:70|unique:majors,name',
        'description' => 'string|max:255',
        'status' => 'required|boolean',
    ];

    private $updateMajorValidation = [
        'name' => 'string|min:4|max:70',
        'description' => 'string|max:255',
        'status' => 'boolean',
    ];

    /**
     * Display a paginated listing of majors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $limit, int $offset = 0, $direction = 'next')
    {
        $result = [];

        // Select fields
        $majorsQuery = Major::select(['id', 'name', 'status']);

        // Keyset pagination
        if ($direction === 'back') {
            $majorsQuery->where('majors.id', '<', $offset)->orderBy('majors.id', 'desc');
        } else {
            $majorsQuery->where('majors.id', '>=', $offset)->orderBy('majors.id', 'asc');
        }

        // Get results
        $majors = $majorsQuery->limit($limit + 1)->get();

        // Check direction
        if ($direction === 'back') {
            // Reverse to the right order
            $majors = $majors->reverse();

            // More results than the limit (there are more pages) before
            if (count($majors) > $limit) {
                $result['next_major_id'] = $offset;
                $result['last_major_id'] = $majors[$limit]->id;

                unset($majors[0]);
            } else {
                // No more pages (first page)
                $result['next_major_id'] = $offset;
                $result['last_major_id'] = null;
            }

        } else {
            // More results than the limit (there are more pages) after
            if (count($majors) > $limit) {
                $result['next_major_id'] = $majors[$limit]->id;
                $result['last_major_id'] = $offset;

                unset($majors[$limit]);
            } else {
                // No more pages (last page)
                $result['last_major_id'] = $offset;
                $result['next_major_id'] = null;
            }
        }

        // Check if last major ID is valid
        if ($result['last_major_id'] < 1) $result['last_major_id'] = null;

        $result['majors'] = $majors;

        // Return JSON response
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Search Major by name
     *
     * @param Request $request
     * @param integer $limit
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, int $limit)
    {
        $validated = $request->validate(['major_search' => 'required|max:70']);

        $result = [];

        $majors = Major::select(['id', 'name', 'status'])
            ->where('name', 'like', $validated['major_search'].'%')->orderBy('name')
            ->limit($limit)->get();

        $result = [
            'majors' => $majors,
        ];

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->newMajorValidation);

        $major = new Major($validated);

        $major->save();

        return response()->json($major, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Major $major)
    {
        return response()->json($major);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Major $major)
    {
        $updateMajorValidationSelf = $this->updateMajorValidation;

        $id = $major->id;

        $updateMajorValidationSelf['name'] = "string|min:4|max:70|unique:majors,name,$id";
        $validated = $request->validate($this->updateMajorValidation);

        $major->update($validated);

        return response()->json($major);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Major $major)
    {
        $major->destroy($major->id);

        return response()->json([
            'message' => 'Major deleted successfully'
        ]);
    }
}

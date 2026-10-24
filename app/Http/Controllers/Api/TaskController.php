<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
public function index(Request $request)
{
    $query = Task::query();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('Mata_Kuliah', 'like', "%{$search}%")
              ->orWhere('Judul_Tugas', 'like', "%{$search}%");
        });
    }

    if ($request->filled('prioritas')) {
        $query->where('Prioritas', $request->prioritas);
    }
    
    if ($request->filled('deadline')) {
        $query->where('Deadline', $request->deadline);
    }

    $tasks = $query->get();

    return response()->json([
        'message' => 'Daftar tugas berhasil diambil',
        'data' => $tasks
    ], 200);
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'Mata_Kuliah' => 'required|string|max:255',
        'Judul_Tugas' => 'required|string|max:255',
        'Keterangan' => 'nullable|string',
        'Deadline' => 'required|date',
        'Jam_Tenggat' => 'required|date_format:H:i:s',
        'Prioritas' => 'required|in:Rendah,Sedang,Tinggi',
        'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ]);
    if ($request->hasFile('file')) {
        $validated['file_path'] = $request->file('file')
            ->store('task-files', 'public');
    }

    unset($validated['file']);

    $task = Task::create($validated);

    return response()->json([
        'message' => 'Tugas berhasil ditambahkan',
        'data' => $task
    ], 201);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Tugas tidak ditemukan'
            ], 404);
        }
        $validated = $request->validate([
            'Mata_Kuliah' => 'sometimes|required|string|max:255',
            'Judul_Tugas' => 'sometimes|required|string|max:255',
            'Keterangan' => 'sometimes|nullable|string',
            'Deadline' => 'sometimes|required|date',
            'Jam_Tenggat' => 'sometimes|required|date_format:H:i:s',
            'Prioritas' => 'sometimes|required|in:Rendah,Sedang,Tinggi',
            'file' => 'sometimes|nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
        $task->update($validated);
        
        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')
                ->store('task-files', 'public');
        }

        unset($validated['file']);

        $task->update($validated);

        return response()->json([
            'message' => 'Tugas berhasil dirubah',
            'data' => $task
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Tugas tidak ditemukan'
            ], 404);
        }

        $task->delete();
        
        return response()->json([
            'message' => 'Tugas berhasil dihapus'
        ], 200);
    }
}

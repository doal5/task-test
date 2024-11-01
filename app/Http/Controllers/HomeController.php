<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = [
            'tasks' => Task::where('user_id', $user->id)->paginate(10)
        ];
        return view('home.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke model Task
        $Task = Task::simpanTugas($validator->validated());

        // Set session flash untuk pesan sukses
        session()->flash('success', 'Data tugas berhasil disimpan!');

        return redirect()->route('home.index');
    }


    public function updateStatus(Request $request, $id)
    {
        $Task = Task::find($id);
        if (!$Task) {
            return redirect()->back()->withErrors(['error' => 'tugas tidak ditemukan']);
        };

        // validasi input
        $validate = $request->validate([
            'status' => 'required|in:belum selesai,selesai'
        ]);
        if ($Task) {
            $Task->status = $validate['status'];
            $Task->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }


    public function uploadGambar(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:png|max:2048', // Validasi untuk file gambar
        ], [
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, gif, atau svg.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $task = Task::findOrFail($id);
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($task->gambar && Storage::disk('public')->exists($task->gambar)) {
                Storage::disk('public')->delete($task->gambar);
            }

            // Simpan gambar baru di storage
            $imagePath = $request->file('gambar')->store('Task', 'public');
            $task->gambar = $imagePath; // Menyimpan path ke database
            $task->save();
        }

        session()->flash('success', 'Gambar berhasil diunggah dan diperbarui!');
        return redirect()->back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);

        if ($task) {
            $task->delete();
            return response()->json(['message' => 'Item berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Item tidak ditemukan'], 404);
        }
    }
}

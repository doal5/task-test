<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'tasks';
    protected $fillable = ['nama', 'deskripsi', 'status', 'user_id', 'gambar'];
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function simpanTugas($data)
    {
        return self::create([
            'nama' => $data['nama'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'status' => 'belum selesai',
            'user_id' => Auth::user()->id,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'Mata_Kuliah',
        'Judul_Tugas',
        'Keterangan',
        'Deadline',
        'Jam_Tenggat',
        'Prioritas',
        'file_path',
    ];
}

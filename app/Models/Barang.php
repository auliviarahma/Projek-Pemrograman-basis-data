<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // Beritahu Laravel nama tabel aslinya di MySQL
    protected $table = 'barang';

    // Beritahu Laravel nama Primary Key aslinya
    protected $primaryKey = 'idbarang';

    // Matikan timestamps otomatis karena tabel tidak memiliki kolom created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'jenis',
        'nama',
        'idsatuan',
        'status',
        'harga',
    ];

    // Relasi ke master satuan
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'idsatuan', 'idsatuan');
    }
}
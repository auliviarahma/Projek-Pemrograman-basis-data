<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Satuan extends Model
{
 protected $table = 'satuan';
    protected $primaryKey = 'idsatuan';
    public $timestamps = false; // Set false jika tabel tidak memiliki kolom created_at dan updated_at bawaan Laravel

    protected $fillable = [
        'nama_satuan',
        'status',
    ];
}
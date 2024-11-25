<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sirkulasi extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan
    protected $table = 'sirkulasis';

    // Tentukan atribut yang bisa diisi
    protected $fillable = [
        'id_buku',
        'id_user',
        'tgl_pinjam',
        'status',
        'tgl_pengembalian',
    ];

    // Mendefinisikan relasi dengan Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    // Mendefinisikan relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Menampilkan Semua Data Sirkulasi dengan Eloquent
    public static function getAllSirkulasi()
    {
        return self::with('buku', 'user')->get();
    }

    // Menambahkan Data Sirkulasi menggunakan Eloquent
    public static function storeSirkulasi($data)
    {
        return self::create($data);
    }

    // Memperbarui Status Sirkulasi menggunakan Eloquent
    public static function updateSirkulasi($id, $data)
    {
        $sirkulasi = self::findOrFail($id);
        $sirkulasi->update($data);
        return $sirkulasi;
    }

    // Menghapus Data Sirkulasi menggunakan Eloquent
    public static function deleteSirkulasi($id)
    {
        $sirkulasi = self::findOrFail($id);
        $sirkulasi->delete();
        return $sirkulasi;
    }
}

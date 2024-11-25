<?php

namespace App\Http\Controllers;

use App\Models\Sirkulasi;
use Illuminate\Http\Request;

class SirkulasiController extends Controller
{
    // 1. Menampilkan Semua Data Sirkulasi
    public function index()
    {
        // $sirkulasi = Sirkulasi::getAllSirkulasi();  // Mengambil data sirkulasi dengan relasi buku dan user
        // return response()->json($sirkulasi); // Mengembalikan data dalam format JSON
        $sirkulasi = Sirkulasi::with(['buku', 'user'])->get();

        return response()->json($sirkulasi);
    }

    // 2. Menambahkan Data Sirkulasi
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:bukus,id',
            'id_user' => 'required|exists:users,id',
            'tgl_pinjam' => 'required|date',
            'status' => 'required|in:pinjam,kembali',
        ]);

        $data = $request->only(['id_buku', 'id_user', 'tgl_pinjam', 'status']);
        Sirkulasi::storeSirkulasi($data);  // Menambahkan data sirkulasi menggunakan metode Eloquent

        return response()->json(['message' => 'Data Sirkulasi berhasil ditambahkan'], 201);
    }

    // 3. Memperbarui Status
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pinjam,kembali',
        ]);

        $data = [
            'status' => $request->status,
            'tgl_pengembalian' => $request->status == 'kembali' ? now() : null,
        ];

        Sirkulasi::updateSirkulasi($id, $data);  // Memperbarui status sirkulasi

        return response()->json(['message' => 'Status Sirkulasi berhasil diperbarui']);
    }

    // 4. Menghapus Data Sirkulasi
    public function destroy($id)
    {
        Sirkulasi::deleteSirkulasi($id);  // Menghapus data sirkulasi
        return response()->json(['message' => 'Data Sirkulasi berhasil dihapus']);
    }
}

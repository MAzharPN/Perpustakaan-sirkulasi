// SirkulasiList.vue
<template>
  <div class="container mt-4">
    <h2>Daftar Sirkulasi</h2>
    <div v-if="loading" class="text-center">
      <p>Loading...</p>
    </div>
    <table v-if="!loading" class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Judul Buku</th>
          <th>Nama User</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(sirkulasi, index) in sirkulasis" :key="sirkulasi.id">
          <td style="color: black;">{{ index + 1 }}</td>
          <td style="color: black;">{{ sirkulasi.buku?.judul || 'Loading...' }}</td>
          <td style="color: black;">{{ sirkulasi.user?.name || 'Loading...' }}</td>
          <td style="color: black;">{{ sirkulasi.tgl_pinjam }}</td>
          <td style="color: black;">{{ sirkulasi.tgl_kembali }}</td>
          <td style="color: black;">{{ sirkulasi.status }}</td>
          <td>
            <button class="btn btn-warning btn-sm" @click="openForm(sirkulasi)" style="margin-right: 5px;">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deleteSirkulasi(sirkulasi.id)" style="margin-top: 5px;">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
    <SirkulasiForm v-if="showForm" :selectedSirkulasi="selectedSirkulasi" @close="closeForm" />
    <button class="btn btn-primary mb-3" @click="openForm()">Tambah Sirkulasi</button>
  </div>
</template>

<script>
import axios from "axios";
import SirkulasiForm from "./SirkulasiForm.vue";

export default {
  name: "SirkulasiList",
  components: { SirkulasiForm },
  data() {
    return {
      sirkulasis: [],
      loading: true,
      showForm: false,
      selectedSirkulasi: null,
    };
  },
  async created() {
    await this.fetchSirkulasis();
  },
  methods: {
    async fetchSirkulasis() {
      this.loading = true;
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/sirkulasi");
        this.sirkulasis = response.data;

        // Untuk setiap sirkulasi, ambil data buku dan user berdasarkan ID
        for (let sirkulasi of this.sirkulasis) {
          const bukuResponse = await axios.get(`http://127.0.0.1:8000/api/buku/${sirkulasi.id_buku}`);
          const userResponse = await axios.get(`http://127.0.0.1:8000/api/user/${sirkulasi.id_user}`);
          
          sirkulasi.buku = bukuResponse.data;
          sirkulasi.user = userResponse.data;
        }
      } catch (error) {
        console.error("Error fetching sirkulasi:", error);
      } finally {
        this.loading = false;
      }
    },
    openForm(sirkulasi = null) {
      this.selectedSirkulasi = sirkulasi;
      this.showForm = true;
    },
    closeForm() {
      this.showForm = false;
      this.fetchSirkulasis();
    },
    async deleteSirkulasi(id) {
      if (confirm("Apakah Anda yakin ingin menghapus sirkulasi ini?")) {
        try {
          await axios.delete(`http://127.0.0.1:8000/api/sirkulasi/${id}`);
          alert("Sirkulasi berhasil dihapus");
          this.fetchSirkulasis();
        } catch (error) {
          console.error("Error deleting sirkulasi:", error);
        }
      }
    },
  },
};
</script>
<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

h2 {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
}

.table {
  width: 100%;
  margin-bottom: 20px;
}

.table-bordered {
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.table th,
.table td {
  padding: 12px;
  text-align: center;
  vertical-align: middle;
}

.table th {
  background-color: #f8f9fa;
  color: #495057;
}

.table tbody tr:nth-child(odd) {
  background-color: #f2f2f2;
}

.table tbody tr:nth-child(even) {
  background-color: #ffffff;
}

.btn {
  border-radius: 4px;
  font-size: 14px;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

.btn-warning {
  background-color: #ffc107;
  border-color: #ffc107;
}

.btn-warning:hover {
  background-color: #e0a800;
  border-color: #e0a800;
}

.btn-danger {
  background-color: #dc3545;
  border-color: #dc3545;
}

.btn-danger:hover {
  background-color: #c82333;
  border-color: #c82333;
}

.mt-4 {
  margin-top: 40px;
}

.mb-3 {
  margin-bottom: 20px;
}

.text-center {
  text-align: center;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  width: 500px;
}
</style>
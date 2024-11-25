<template>
    <div class="modal-overlay">
      <div class="modal-content">
        <h3>{{ selectedSirkulasi ? "Edit Sirkulasi" : "Tambah Sirkulasi" }}</h3>
        <form @submit.prevent="submitForm">
          <div class="form-group">
            <label>Judul Buku</label>
            <input type="text" v-model="sirkulasi.buku.judul" class="form-control" required readonly />
          </div>
          <div class="form-group">
            <label>Nama User</label>
            <input type="text" v-model="sirkulasi.user.name" class="form-control" required readonly />
          </div>
          <div class="form-group">
            <label>Tanggal Pinjam</label>
            <input type="date" v-model="sirkulasi.tgl_pinjam" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" v-model="sirkulasi.tgl_kembali" class="form-control" />
          </div>
          <div class="form-group">
            <label>Status</label>
            <select v-model="sirkulasi.status" class="form-control" required>
              <option value="pinjam">Pinjam</option>
              <option value="kembali">Kembali</option>
            </select>
          </div>
          <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" @click="$emit('close')">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "SirkulasiForm",
    props: ["selectedSirkulasi"],
    data() {
      return {
        sirkulasi: {
          id_buku: "",
          id_user: "",
          tgl_pinjam: "",
          tgl_kembali: "",
          status: "pinjam",
          buku: {
            judul: "",
          },
          user: {
            name: "",
          },
        },
      };
    },
    created() {
      if (this.selectedSirkulasi) {
        this.sirkulasi = {
          ...this.selectedSirkulasi,
          buku: {
            judul: this.selectedSirkulasi.buku.judul,
          },
          user: {
            name: this.selectedSirkulasi.user.name,
          },
        };
      }
    },
    methods: {
      async submitForm() {
        try {
          const dataToSend = {
            id_buku: this.sirkulasi.id_buku,
            id_user: this.sirkulasi.id_user,
            tgl_pinjam: this.sirkulasi.tgl_pinjam,
            tgl_kembali: this.sirkulasi.tgl_kembali,
            status: this.sirkulasi.status,
          };
  
          if (this.selectedSirkulasi) {
            // Update existing sirkulasi
            await axios.put(`http://127.0.0.1:8000/api/sirkulasi/${this.sirkulasi.id}`, dataToSend);
            alert("Sirkulasi berhasil diperbarui");
          } else {
            // Create new sirkulasi
            await axios.post("http://127.0.0.1:8000/api/sirkulasi", dataToSend);
            alert("Sirkulasi berhasil ditambahkan");
          }
  
          this.$emit("close");
        } catch (error) {
          console.error("Error saving sirkulasi:", error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
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
    width: 400px;
  }
  </style>
  
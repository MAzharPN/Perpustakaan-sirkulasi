import { createRouter, createWebHistory } from "vue-router";
import BukuList from "../components/BukuList.vue";
import SirkulasiList from "../components/SirkulasiList.vue"; // pastikan komponen ini ada

const routes = [
  {
    path: "/bukus",
    name: "BukuList",
    component: BukuList,
  },
  {
    path: "/sirkulasi", // tambahkan route untuk sirkulasi
    name: "SirkulasiList",
    component: SirkulasiList, // pastikan ini adalah path yang benar ke komponen Anda
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

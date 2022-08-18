import Angkatan from '../admin/pages/masterdata/Angkatan.vue';
import Fakultas from '../admin/pages/masterdata/Fakultas.vue';
import Jurusan from '../admin/pages/masterdata/Jurusan.vue';
import Prodi from '../admin/pages/masterdata/Prodi.vue';
import Dashboard from '../admin/pages/Dashboard.vue';
import Kegiatan from '../admin/pages/Kegiatan.vue';
import Mahasiswa from '../admin/pages/Mahasiswa.vue';
import PembimbingAkademik from '../admin/pages/PembimbingAkademik.vue';
import FormsAngkatan from '../admin/pages/forms/FormsAngkatan.vue';
import FormsFakultas from '../admin/pages/forms/FormsFakultas.vue';
import FormsJurusan from '../admin/pages/forms/FormsJurusan.vue';
import FormsProdi from '../admin/pages/forms/FormsProdi.vue';
import FormsMahasiswa from '../admin/pages/forms/FormsMahasiswa.vue';
import FormsPembimbingAkademik from '../admin/pages/forms/FormsPembimbingAkademik';
import AssignMahasiswa from '../admin/pages/forms/AssignMahasiswa';

export const AdminRoutes = [
    { name: 'dashboard', path: '/portofolio/admin/dashboard', component: Dashboard },
    { name: 'kegiatan', path: '/portofolio/admin/kegiatan', component: Kegiatan },
    // Angkatan
    { name: 'angkatan', path: '/portofolio/admin/angkatan', component: Angkatan },
    { name: 'angkatanCreate', path: '/portofolio/admin/angkatan/create', component: FormsAngkatan },
    { name: 'angkatanEdit', path: '/portofolio/admin/angkatan/edit/:id', component: FormsAngkatan },
    // Fakultas
    { name: 'fakultas', path: '/portofolio/admin/fakultas', component: Fakultas },
    { name: 'fakultasCreate', path: '/portofolio/admin/fakultas/create', component: FormsFakultas },
    { name: 'fakultasEdit', path: '/portofolio/admin/fakultas/edit/:id', component: FormsFakultas },
    // Jurusan
    { name: 'jurusan', path: '/portofolio/admin/jurusan', component: Jurusan },
    { name: 'jurusanCreate', path: '/portofolio/admin/jurusan/create', component: FormsJurusan },
    { name: 'jurusanEdit', path: '/portofolio/admin/jurusan/edit/:id', component: FormsJurusan },
    // Prodi
    { name: 'prodi', path: '/portofolio/admin/prodi', component: Prodi },
    { name: 'prodiCreate', path: '/portofolio/admin/prodi/create', component: FormsProdi },
    { name: 'prodiEdit', path: '/portofolio/admin/prodi/edit/:id', component: FormsProdi },
    // Mahasiswa
    { name: 'mahasiswa', path: '/portofolio/admin/mahasiswa', component: Mahasiswa },
    { name: 'mahasiswaCreate', path: '/portofolio/admin/mahasiswa/create', component: FormsMahasiswa },
    { name: 'mahasiswaEdit', path: '/portofolio/admin/mahasiswa/edit/:id', component: FormsMahasiswa },
    //Pembimbing Akademik
    { name: 'pembimbingakademik', path: '/portofolio/admin/pembimbingakademik', component: PembimbingAkademik },
    { name: 'pembimbingAkademikCreate', path: '/portofolio/admin/pembimbingakademik/create', component: FormsPembimbingAkademik },
    { name: 'pembimbingAkademikEdit', path: '/portofolio/admin/pembimbingakademik/edit/:id', component: FormsPembimbingAkademik },
    { name: 'assignMahasiswa', path: '/portofolio/admin/assignmahasiswa/:id', component: AssignMahasiswa },
];

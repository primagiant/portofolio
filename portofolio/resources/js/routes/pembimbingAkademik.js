import Dashboard from '../pembimbingAkademik/pages/Dashboard.vue';
import Kegiatan from '../pembimbingAkademik/pages/Kegiatan.vue';
import PerluValidasi from '../pembimbingAkademik/pages/PerluValidasi.vue';
import DetailPerluValidasi from '../pembimbingAkademik/pages/DetailPerluValidasi.vue';
import MahasiswaDiampu from '../pembimbingAkademik/pages/MahasiswaDiampu.vue';
import SudahValidasi from '../pembimbingAkademik/pages/SudahValidasi.vue';
import DetailSudahValidasi from '../pembimbingAkademik/pages/DetailSudahValidasi.vue';

export const PembimbingAkademikRoutes = [
    { name: 'dashboard', path: '/portofolio/pembimbing-akademik/dashboard', component: Dashboard },
    { name: 'kegiatan', path: '/portofolio/pembimbing-akademik/kegiatan', component: Kegiatan },
    { name: 'perluValidasi', path: '/portofolio/pembimbing-akademik/mahasiswa/non-valid', component: PerluValidasi },
    { name: 'detailPerluValidasi', path: '/portofolio/pembimbing-akademik/mahasiswa/:nim/non-valid', component: DetailPerluValidasi },
    { name: 'mahasiswaDiampu', path: '/portofolio/pembimbing-akademik/mahasiswa/all', component: MahasiswaDiampu },
    { name: 'sudahValidasi', path: '/portofolio/pembimbing-akademik/mahasiswa/valid', component: SudahValidasi },
    { name: 'detailSudahValidasi', path: '/portofolio/pembimbing-akademik/mahasiswa/:nim/valid', component: DetailSudahValidasi },
];

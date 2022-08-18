import Dashboard from '../mahasiswa/pages/Dashboard.vue'
import Kegiatan from '../mahasiswa/pages/Kegiatan.vue'
import Portofolio from '../mahasiswa/pages/Portofolio.vue'
import FormsPortofolio from '../mahasiswa/pages/forms/FormsPortofolio.vue'

export const MahasiswaRoutes = [
    { name: 'dashboard', path: '/portofolio/mahasiswa/dashboard', component: Dashboard },
    { name: 'kegiatan', path: '/portofolio/mahasiswa/kegiatan', component: Kegiatan },
    { name: 'portofolio', path: '/portofolio/mahasiswa/portofolio', component: Portofolio },
    { name: 'portofolioCreate', path: '/portofolio/mahasiswa/portofolio/create', component: FormsPortofolio },
    { name: 'portofolioEdit', path: '/portofolio/mahasiswa/portofolio/edit/:id', component: FormsPortofolio },
]

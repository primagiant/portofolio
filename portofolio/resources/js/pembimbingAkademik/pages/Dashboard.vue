<template>
    <div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome {{ pembimbingAkademik.nama }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale csr-pointer" @click="redirectToPerluValidasi()">
                            <div class="card-body">
                                <p class="mb-4">Perlu Divalidasi</p>
                                <p class="fs-30 mb-2">{{ perluValidasi }}</p>
                                <p>Portofolio</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue csr-pointer" @click="redirectToSudahValidasi()">
                            <div class="card-body">
                                <p class="mb-4">Sudah Divalidasi</p>
                                <p class="fs-30 mb-2">{{ sudahValidasi }}</p>
                                <p>Portofolio</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Banyaknya Portofolio</p>
                                <p class="fs-30 mb-2">{{ totalPortofolio }}</p>
                                <p>Portofolio</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Mahasiswa Diampu</p>
                                <p class="fs-30 mb-2">{{ banyakMahasiswa }}</p>
                                <p>Mahasiswa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 mb-4 mb-xl-0">
                                <p class="card-title mb-0">Top Mahasiswa</p>
                            </div>
                            <div class="col-4">
                                <div class="justify-content-end d-flex">
                                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="mdi mdi-calendar"></i>
                                            Angkatan ( {{ selectedAngkatan }} )
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                            <div v-for="(item, index) in angkatan" :key="index">
                                                <button @click="filterAngkatan(item.id)" class="dropdown-item" href="#">{{ item.tahun }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="isThereMahasiswaAngkatan === true">
                                        <tr v-for="(item, index) in mahasiswa.data" :key="index">
                                            <td>{{ index + 1 }}</td>
                                            <td class="font-weight-bold">{{ item.nim }}</td>
                                            <td>{{ item.nama }}</td>
                                            <td class="font-weight-medium">{{ item.totalSkor }}</td>
                                        </tr>
                                    </template>
                                    <tr v-else>
                                        <td colspan="4" class="text-center">Tidak ada Data Mahasiswa</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pembimbingAkademik: {},
            angkatan: {},
            selectedAngkatan: "",
            perluValidasi: 0,
            sudahValidasi: 0,
            totalPortofolio: 0,
            banyakMahasiswa: 0,
            mahasiswa: {},
            isThereMahasiswaAngkatan: false,
        };
    },
    mounted() {
        axios.get("/portofolio/api/pembimbingakademik").then((response) => {
            this.pembimbingAkademik = response.data.data;
        });
        axios.get("/portofolio/api/angkatan").then((response) => {
            this.angkatan = response.data.data;
            this.selectedAngkatan = this.angkatan[0].tahun;
            this.filterAngkatan(this.angkatan[0].id);
        });
        this.calculateValidation();
    },
    methods: {
        filterAngkatan(id) {
            for (let i in this.angkatan) {
                if (this.angkatan[i].id == id) {
                    this.selectedAngkatan = this.angkatan[i].tahun;
                }
            }
            axios.get("/portofolio/api/mahasiswa/topMahasiswa/" + id).then((response) => {
                this.mahasiswa = response.data;
                if (response.data.data.length !== 0) {
                    this.isThereMahasiswaAngkatan = true;
                } else {
                    this.isThereMahasiswaAngkatan = false;
                }
            });
        },
        calculateValidation() {
            axios.get("/portofolio/api/mahasiswa").then((response) => {
                for (let i = 0; i < response.data.data.length; i++) {
                    axios.get("/portofolio/api/portofolio/byNim/" + response.data.data[i].nim).then((res) => {
                        this.perluValidasi += res.data.data.perluValidasi.length;
                        this.sudahValidasi += res.data.data.sudahValidasi.length;
                        this.totalPortofolio = this.perluValidasi + this.sudahValidasi;
                    });
                }
                this.banyakMahasiswa = response.data.data.length;
            });
        },
        redirectToPerluValidasi() {
            this.$router.push({ name: "perluValidasi" });
        },
        redirectToSudahValidasi() {
            this.$router.push({ name: "sudahValidasi" });
        },
    },
};
</script>

<style scoped>
.csr-pointer {
    cursor: pointer;
}
</style>

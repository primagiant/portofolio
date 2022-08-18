<template>
    <div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome Admin</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Waktu Sistem</p>
                                <p class="h3 mb-2">{{ time }}</p>
                                <p>Waktu Setempat</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Jumlah Total Portofolio</p>
                                <p class="fs-30 mb-2">{{ totalPortofolio }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue csr-pointer" @click="redirectToPembimbingAkademik()">
                            <div class="card-body">
                                <p class="mb-4">Pembimbing Akademik</p>
                                <p class="fs-30 mb-2">{{ banyakPA }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger csr-pointer" @click="redirectToMahasiswa()">
                            <div class="card-body">
                                <p class="mb-4">Jumlah Mahasiswa</p>
                                <p class="fs-30 mb-2">{{ banyakMahasiswa }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                <p class="card-title mb-0">Top Mahasiswa</p>
                            </div>
                            <div class="col-12 col-xl-4">
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            banyakPA: 0,
            angkatan: {},
            selectedAngkatan: "",
            selectedAngkatanID: "",
            totalPortofolio: 0,
            banyakMahasiswa: 0,
            interval: null,
            time: null,
            mahasiswa: {},
            isThereMahasiswaAngkatan: false,
        };
    },
    beforeDestroy() {
        clearInterval(this.interval);
    },
    created() {
        this.interval = setInterval(() => {
            this.time = Intl.DateTimeFormat(navigator.language, {
                hour: "numeric",
                minute: "numeric",
                second: "numeric",
            }).format();
        }, 1000);
        axios.get("/portofolio/api/countPortofolio").then((response) => {
            this.totalPortofolio = response.data.data;
        });
        axios.get("/portofolio/api/pembimbingakademik").then((response) => {
            this.banyakPA = response.data.data.length;
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
                this.banyakMahasiswa = response.data.data.length;
            });
        },
        redirectToMahasiswa() {
            this.$router.push({ name: "mahasiswa" });
        },
        redirectToPembimbingAkademik() {
            this.$router.push({ name: "pembimbingakademik" });
        },
    },
};
</script>

<style scoped>
.csr-pointer {
    cursor: pointer;
}
</style>

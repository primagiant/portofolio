<template>
    <div>
        <div class="col-md-12">
            <h3 v-if="$route.params.id" class="card-title">Edit Pembimbing Akademik</h3>
            <h3 v-else class="card-title">Tambah Pembimbing Akademik</h3>
        </div>
        <form @submit.prevent="saveData">
            <div class="row">
                <div class="grid-margin stretch-card col-md-6">
                    <div class="card rounded-lg">
                        <div class="card-body">
                            <div>
                                <div class="form-group">
                                    <label for="name">Nama Pembimbing Akademik</label>
                                    <input v-model="datas.name" type="text" autofocus class="form-control" :class="{ 'is-invalid': errors.name }" placeholder="Nama Pembimbing Akademik" />
                                    <div v-if="errors.name" class="invalid-feedback">
                                        {{ errors.name[0] }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fakultas_id">Fakultas</label>
                                    <select v-model="selectedFakultas" class="form-control select-text" :class="{ 'is-invalid border-danger': errors.fakultas_id }">
                                        <option disabled value="">Select Fakultas</option>
                                        <option v-for="item in fakultas.data" :key="item.id" :value="item.id">{{ item.nama_fakultas }}</option>
                                    </select>
                                    <div v-if="errors.fakultas_id" class="invalid-feedback">
                                        {{ errors.fakultas_id[0] }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jurusan_id">Jurusan</label>
                                    <select v-model="selectedJurusan" class="form-control select-text" :class="{ 'is-invalid border-danger': errors.jurusan_id }">
                                        <option disabled value="">Select Jurusan</option>
                                        <option v-for="item in jurusan.data" :key="item.id" :value="item.id">{{ item.nama_jurusan }}</option>
                                    </select>
                                    <div v-if="errors.jurusan_id" class="invalid-feedback">
                                        {{ errors.jurusan_id[0] }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="prodi_id">Prodi</label>
                                    <select v-model="selectedProdi" class="form-control select-text" :class="{ 'is-invalid border-danger': errors.prodi_id }">
                                        <option disabled value="">Select Prodi</option>
                                        <option v-for="item in prodi.data" :key="item.id" :value="item.id">{{ item.nama_prodi }}</option>
                                    </select>
                                    <div v-if="errors.prodi_id" class="invalid-feedback">
                                        {{ errors.prodi_id[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-lg">
                        <div class="card-body">
                            <div>
                                <div class="form-group">
                                    <label for="nama">Email</label>
                                    <input v-model="datas.email" type="email" autofocus class="form-control" :class="{ 'is-invalid': errors.email }" placeholder="Email" />
                                    <div v-if="errors.email" class="invalid-feedback">
                                        {{ errors.email[0] }}
                                    </div>
                                </div>

                                <div v-if="!$route.params.id" class="form-group">
                                    <label for="nama">Password</label>
                                    <input v-model="datas.password" type="password" autofocus class="form-control" :class="{ 'is-invalid': errors.password }" placeholder="Password" />
                                    <div v-if="errors.password" class="invalid-feedback">
                                        {{ errors.password[0] }}
                                    </div>
                                </div>

                                <div v-if="!$route.params.id" class="form-group">
                                    <label for="nama">Konfirmasi Password</label>
                                    <input v-model="datas.password_confirmation" type="password" autofocus class="form-control" :class="{ 'is-invalid': errors.password }" placeholder="Konfirmasi Password" />
                                </div>

                                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                                <router-link :to="{ name: 'pembimbingakademik' }" class="btn btn-light">Kembali</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            fakultas: {},
            jurusan: {},
            prodi: {},
            datas: {
                name: null,
                fakultas_id: null,
                jurusan_id: null,
                prodi_id: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            errors: {},
            selectedFakultas: "",
            selectedJurusan: "",
            selectedProdi: "",
        };
    },
    mounted() {
        axios.get("/portofolio/api/pembimbingakademik").then((response) => {
            this.pembimbingakademik = response.data;
        });
        axios.get("/portofolio/api/fakultas/").then((response) => {
            this.fakultas = response.data;
        });
        if (this.$route.params.id) {
            this.axios.get("/portofolio/api/pembimbingakademik/" + this.$route.params.id).then((response) => {
                console.log(response.data);
                this.datas.name = response.data.data.nama;
                this.selectedFakultas = response.data.data.fakultas_id;
                this.selectedJurusan = response.data.data.jurusan_id;
                this.selectedProdi = response.data.data.prodi_id;
                this.datas.email = response.data.data.user.email;
                console.log(response.data.data);
            });
        }
    },

    watch: {
        selectedFakultas: function (value) {
            axios.get("/portofolio/api/jurusan/byFakultas/" + this.selectedFakultas).then((response) => {
                this.jurusan = response.data;
                this.datas.fakultas_id = this.selectedFakultas;
            });
        },
        selectedJurusan: function (value) {
            axios.get("/portofolio/api/prodi/byJurusan/" + this.selectedJurusan).then((response) => {
                this.prodi = response.data;
                this.datas.jurusan_id = this.selectedJurusan;
            });
        },
        selectedProdi: function (value) {
            this.datas.prodi_id = this.selectedProdi;
        },
    },
    methods: {
        saveData: function (e) {
            e.preventDefault();
            if (this.$route.params.id) {
                axios
                    .put("/portofolio/api/pembimbingakademik/" + this.$route.params.id, this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "pembimbingakademik" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    });
            } else {
                axios
                    .post("/portofolio/api/pembimbingakademik", this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "pembimbingakademik" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    });
            }
        },
    },
};
</script>

<style scoped>
.select-text {
    color: #495057;
}
</style>

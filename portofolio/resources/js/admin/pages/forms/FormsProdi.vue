<template>
    <div>
        <div class="col-md-12">
            <h3 v-if="$route.params.id" class="card-title">Edit Prodi</h3>
            <h3 v-else class="card-title">Tambah Prodi</h3>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="saveData" class="forms-sample">
                        <div class="form-group">
                            <label for="nama_prodi">Prodi</label>
                            <input v-model="datas.nama_prodi" type="text" autofocus class="form-control" :class="{ 'is-invalid': errors.nama_prodi }" name="nama_prodi" placeholder="Nama Prodi" />
                            <div v-if="errors.nama_prodi" class="invalid-feedback">
                                {{ errors.nama_prodi[0] }}
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
                            <label for="deskripsi">Deskripsi</label>
                            <textarea v-model="datas.deskripsi" class="form-control" :class="{ 'is-invalid': errors.deskripsi }" name="deskripsi" rows="6"></textarea>
                            <div v-if="errors.deskripsi" class="invalid-feedback">
                                {{ errors.deskripsi[0] }}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                        <router-link :to="{ name: 'prodi' }" class="btn btn-light">Kembali</router-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            fakultas: {},
            jurusan: {},
            datas: {
                nama_prodi: null,
                fakultas_id: null,
                jurusan_id: null,
                deskripsi: null,
            },
            errors: {},
            selectedFakultas: "",
            selectedJurusan: "",
        };
    },
    mounted() {
        axios.get("/portofolio/api/fakultas").then((response) => {
            this.fakultas = response.data;
        });
        if (this.$route.params.id) {
            this.axios.get("/portofolio/api/prodi/" + this.$route.params.id).then((response) => {
                this.datas.nama_prodi = response.data.data.nama_prodi;
                this.datas.fakultas_id = response.data.data.fakultas_id;
                this.datas.jurusan_id = response.data.data.jurusan_id;
                this.selectedFakultas = response.data.data.fakultas_id;
                this.selectedJurusan = response.data.data.jurusan_id;
                this.datas.deskripsi = response.data.data.deskripsi;
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
            this.datas.jurusan_id = this.selectedJurusan;
        },
    },
    methods: {
        saveData: function (e) {
            e.preventDefault();
            if (this.$route.params.id) {
                axios
                    .put("/portofolio/api/prodi/" + this.$route.params.id, this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "prodi" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    });
            } else {
                console.log(this.datas);
                axios
                    .post("/portofolio/api/prodi", this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "prodi" });
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

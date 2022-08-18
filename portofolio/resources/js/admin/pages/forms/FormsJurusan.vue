<template>
    <div>
        <div class="col-md-12">
            <h3 v-if="$route.params.id" class="card-title">Edit Jurusan</h3>
            <h3 v-else class="card-title">Tambah Jurusan</h3>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="saveData" class="forms-sample">
                        <div class="form-group">
                            <label for="nama_jurusan">Jurusan</label>
                            <input v-model="datas.nama_jurusan" type="text" autofocus class="form-control" :class="{ 'is-invalid': errors.nama_jurusan }" name="nama_jurusan" placeholder="Nama Jurusan" />
                            <div v-if="errors.nama_jurusan" class="invalid-feedback">
                                {{ errors.nama_jurusan[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fakultas_id">Fakultas</label>
                            <select v-model="datas.fakultas_id" class="form-control select-text" :class="{ 'is-invalid border-danger': errors.fakultas_id }">
                                <option disabled value="">Select Fakultas</option>
                                <option v-for="item in fakultas.data" :key="item.id" :value="item.id">{{ item.nama_fakultas }}</option>
                            </select>
                            <div v-if="errors.fakultas_id" class="invalid-feedback">
                                {{ errors.fakultas_id[0] }}
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
                        <router-link :to="{ name: 'jurusan' }" class="btn btn-light">Kembali</router-link>
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
            datas: {
                nama_jurusan: null,
                fakultas_id: "",
                deskripsi: null,
            },
            errors: {},
        };
    },
    mounted() {
        axios.get("/portofolio/api/fakultas").then((response) => {
            this.fakultas = response.data;
        });
        if (this.$route.params.id) {
            this.axios.get("/portofolio/api/jurusan/" + this.$route.params.id).then((response) => {
                this.datas.nama_jurusan = response.data.data.nama_jurusan;
                this.datas.fakultas_id = response.data.data.fakultas_id;
                console.log(this.datas.fakultas_id);
                this.datas.deskripsi = response.data.data.deskripsi;
            });
        }
    },
    methods: {
        saveData: function (e) {
            console.log(this.datas.fakultas_id);
            e.preventDefault();
            if (this.$route.params.id) {
                axios
                    .put("/portofolio/api/jurusan/" + this.$route.params.id, this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "jurusan" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    });
            } else {
                axios
                    .post("/portofolio/api/jurusan", this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "jurusan" });
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

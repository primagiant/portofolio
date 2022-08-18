<template>
    <div>
        <div class="col-md-12">
            <h3 v-if="$route.params.id" class="card-title">Edit Fakultas</h3>
            <h3 v-else class="card-title">Tambah Fakultas</h3>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="saveData" class="forms-sample">
                        <div class="form-group">
                            <label for="nama_fakultas">Fakultas</label>
                            <input v-model="datas.nama_fakultas" type="text" autofocus="autofocus" class="form-control" :class="{ 'is-invalid': errors.nama_fakultas }" name="fakultas" id="fakultas" placeholder="Fakultas" />
                            <div v-if="errors.nama_fakultas" class="invalid-feedback">
                                {{ errors.nama_fakultas[0] }}
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
                        <router-link :to="{ name: 'fakultas' }" class="btn btn-light">Kembali</router-link>
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
            datas: {
                nama_fakultas: null,
                deskripsi: null,
            },
            errors: {},
        };
    },
    mounted() {
        if (this.$route.params.id) {
            axios.get("/portofolio/api/fakultas/" + this.$route.params.id).then((response) => {
                console.log(response);
                this.datas.nama_fakultas = response.data.data.nama_fakultas;
                this.datas.deskripsi = response.data.data.deskripsi;
            })
        }
    },
    methods: {
        saveData: function (e) {
            e.preventDefault();
            if (this.$route.params.id) {
                axios
                    .put("/portofolio/api/fakultas/" + this.$route.params.id, this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "fakultas" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    });
            } else {
                axios
                    .post("/portofolio/api/fakultas", this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "fakultas" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    });
            }
        },
    },
};
</script>

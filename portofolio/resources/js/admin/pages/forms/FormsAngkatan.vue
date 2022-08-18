<template>
    <div>
        <div class="col-md-12">
            <h3 v-if="$route.params.id" class="card-title">Edit Angkatan</h3>
            <h3 v-else class="card-title">Tambah Angkatan</h3>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="saveData" class="forms-sample">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input v-model="datas.tahun" type="text" autofocus="autofocus" class="form-control" :class="{ 'is-invalid': errors.tahun }" name="tahun" id="tahun" placeholder="Tahun" />
                            <div v-if="errors.tahun" class="invalid-feedback">
                                {{ errors.tahun[0] }}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                        <router-link :to="{ name: 'angkatan' }" class="btn btn-light">Kembali</router-link>
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
                tahun: null,
            },
            errors: {},
        };
    },
    mounted() {
        if (this.$route.params.id) {
            this.axios.get("/portofolio/api/angkatan/" + this.$route.params.id).then((response) => {
                this.datas.tahun = response.data.data.tahun;
            });
        }
    },
    methods: {
        saveData: function (e) {
            e.preventDefault();
            if (this.$route.params.id) {
                axios
                    .put("/portofolio/api/angkatan/" + this.$route.params.id, this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "angkatan" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    });
            } else {
                axios
                    .post("/portofolio/api/angkatan", this.datas)
                    .then((response) => {
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "angkatan" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    });
            }
        },
    },
};
</script>

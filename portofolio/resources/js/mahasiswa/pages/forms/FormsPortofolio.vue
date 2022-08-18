<template>
    <div>
        <loading :active.sync="isLoading"></loading>
        <div class="col-md-12">
            <h3 v-if="$route.params.id" class="card-title">Edit Portofolio</h3>
            <h3 v-else class="card-title">Tambah Portofolio</h3>
        </div>
        <div class="col-xl-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="saveData" enctype="multipart/form-data" class="forms-sample">
                        <div class="form-group">
                            <label for="nama_kegiatan">Nama Kegiatan</label>
                            <input v-model="datas.nama_kegiatan" type="text" autofocus="autofocus" class="form-control" :class="{ 'is-invalid': errors.nama_kegiatan }" required placeholder="Nama Kegiatan" />
                            <div v-if="errors.nama_kegiatan" class="invalid-feedback">
                                {{ errors.nama_kegiatan[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="penyelenggara">Penyelenggara</label>
                            <input v-model="datas.penyelenggara" type="text" autofocus="autofocus" class="form-control" :class="{ 'is-invalid': errors.penyelenggara }" required placeholder="Penyelenggara" />
                            <div v-if="errors.penyelenggara" class="invalid-feedback">
                                {{ errors.penyelenggara[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kategori Kegiatan</label>
                            <select v-model="selectedKategoriKegiatan" class="form-control select-text" :class="{ 'is-invalid border-danger': errors.kategori_kegiatan_id }">
                                <option disabled value="">Select Kategori Kegiatan</option>
                                <option v-for="item in kategori_kegiatan.data" :key="item.id" :value="item.id">{{ item.nama }}</option>
                            </select>
                            <div v-if="errors.kategori_kegiatan_id" class="invalid-feedback">
                                {{ errors.kategori_kegiatan_id[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kegiatan</label>
                            <select v-model="selectedJenisKegiatan" class="form-control select-text" :class="{ 'is-invalid border-danger': errors.jenis_kegiatan_id }">
                                <option disabled value="">Select Jenis Kegiatan</option>
                                <option v-for="item in jenis_kegiatan.jenis_kegiatan" :key="item.id" :value="item.id">{{ item.nama }}</option>
                            </select>
                            <div v-if="errors.jenis_kegiatan_id" class="invalid-feedback">
                                {{ errors.jenis_kegiatan_id[0] }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tahun">Ref Point</label>
                                    <input v-model="ref_point" type="text" disabled class="form-control" name="tahun" id="tahun" placeholder="Tahun" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input v-model="datas.tahun" type="text" autofocus="autofocus" class="form-control" :class="{ 'is-invalid': errors.tahun }" name="tahun" id="tahun" placeholder="Tahun" />
                                    <div v-if="errors.tahun" class="invalid-feedback">
                                        {{ errors.tahun[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tahun">Semester</label>
                                    <div class="form-check my-0">
                                        <div class="ml-4">
                                            <input type="radio" class="form-check-input" v-model="datas.semester_id" checked value="1" />
                                            Ganjil
                                        </div>
                                        <div class="ml-4">
                                            <input type="radio" class="form-check-input" v-model="datas.semester_id" value="2" />
                                            Genap
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bukti">Bukti</label>
                            <input v-if="$route.params.id" @change="onChangeFileUpload()" ref="bukti" type="file" autofocus="autofocus" class="form-control" :class="{ 'is-invalid': invalid }" id="bukti" placeholder="Bukti" />
                            <input v-else @change="onChangeFileUpload()" ref="bukti" type="file" autofocus="autofocus" class="form-control" :class="{ 'is-invalid': errors.bukti }" id="bukti" placeholder="Bukti" />
                            <div v-if="errors.bukti" class="invalid-feedback">
                                {{ errors.bukti[0] }}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                        <router-link :to="{ name: 'portofolio' }" class="btn btn-light">Kembali</router-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    components: {
        Loading,
    },
    data() {
        return {
            isLoading: false,
            isSuccess: false,
            kategori_kegiatan: {},
            jenis_kegiatan: {},
            ref_point: 0,
            datas: {
                nama_kegiatan: null,
                penyelenggara: null,
                tahun: null,
                semester_id: "1",
                kategori_kegiatan_id: "",
                jenis_kegiatan_id: "",
                bukti: null,
            },
            selectedKategoriKegiatan: "",
            selectedJenisKegiatan: "",
            errors: {},
            buktiImage: "",
        };
    },
    watch: {
        selectedKategoriKegiatan: function (value) {
            axios.get("/portofolio/api/kegiatan/" + this.selectedKategoriKegiatan).then((response) => {
                this.jenis_kegiatan = response.data.data;
            });
            this.ref_point = 0;
        },
        selectedJenisKegiatan: function (value) {
            axios.get("/portofolio/api/jeniskegiatan/" + this.selectedJenisKegiatan).then((response) => {
                this.ref_point = response.data.data.ref_point;
            });
            this.datas.kategori_kegiatan_id = this.selectedKategoriKegiatan;
            this.datas.jenis_kegiatan_id = this.selectedJenisKegiatan;
        },
    },
    created() {
        axios.get("/portofolio/api/kategorikegiatan").then((response) => {
            this.kategori_kegiatan = response.data;
        });
        if (this.$route.params.id) {
            this.axios.get("/portofolio/api/portofolio/" + this.$route.params.id).then((response) => {
                this.datas.nama_kegiatan = response.data.data.nama_kegiatan;
                this.datas.penyelenggara = response.data.data.penyelenggara;
                this.datas.tahun = response.data.data.tahun;
                this.selectedKategoriKegiatan = response.data.data.kategori_kegiatan_id;
                this.selectedJenisKegiatan = response.data.data.jenis_kegiatan_id;
                this.ref_point = response.data.data.ref_point;
            });
        }
    },
    methods: {
        saveData: function (e) {
            e.preventDefault();

            this.isLoading = true;
            this.isSuccess = false;

            let formData = new FormData();
            formData.append("nama_kegiatan", this.datas.nama_kegiatan);
            formData.append("penyelenggara", this.datas.penyelenggara);
            formData.append("tahun", this.datas.tahun);
            formData.append("semester_id", this.datas.semester_id);
            formData.append("kategori_kegiatan_id", this.datas.kategori_kegiatan_id);
            formData.append("jenis_kegiatan_id", this.datas.jenis_kegiatan_id);
            if (this.datas.bukti != null) {
                formData.append("bukti", this.datas.bukti);
            }

            if (this.$route.params.id) {
                axios
                    .post("/portofolio/api/portofolio/" + this.$route.params.id, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        this.isSuccess = true;
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "portofolio" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            } else {
                axios
                    .post("/portofolio/api/portofolio", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        this.isSuccess = true;
                        this.$swal.fire({ title: "Success!", text: response.data.message, icon: "success", timer: 1000 });
                        this.$router.push({ name: "portofolio" });
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },
        onChangeFileUpload: function () {
            this.datas.bukti = this.$refs.bukti.files[0];
        },
    },
};
</script>

<style scoped>
.select-text {
    color: #495057;
}
</style>

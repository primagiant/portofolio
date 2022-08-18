<template>
    <div>
        <div class="col-md-12 mb-3">
            <h3>Detail Portofolio Non Valid</h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <form @submit.prevent="validasi" class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Penyelenggara</th>
                                    <th class="text-center th-width">Point Referensi</th>
                                    <th class="text-center th-width">Valid Point</th>
                                    <th class="text-center" width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in portofolio.perluValidasi" :key="index">
                                    <td>{{ item.nama_kegiatan }}</td>
                                    <td class="text-center">{{ item.tahun }}</td>
                                    <td class="text-center">{{ item.penyelenggara }}</td>
                                    <td class="text-center">{{ item.ref_point }}</td>
                                    <td class="text-center">
                                        <input class="form-control text-center" v-model.number="portofolioPoint[index]" type="number" min="0" />
                                    </td>
                                    <td class="text-center">
                                        <button type="button" data-toggle="modal" :data-target="'#exampleModal' + index" class="btn btn-sm btn-primary">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <i class="ti-eye"></i>
                                            </div>
                                        </button>
                                    </td>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'exampleModal' + index" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="row">
                                                    <div class="col-12 card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <h3>Detail Portofolio</h3>
                                                            </div>
                                                            <div class="row">
                                                                <strong class="col-sm-3 col-form-label">Nama Kegiatan</strong>
                                                                <label class="col-sm-9 col-form-label">
                                                                    {{ item.nama_kegiatan }}
                                                                </label>
                                                            </div>
                                                            <div class="row">
                                                                <strong class="col-sm-3 col-form-label">Penyelenggara</strong>
                                                                <label class="col-sm-9 col-form-label">
                                                                    {{ item.penyelenggara }}
                                                                </label>
                                                            </div>
                                                            <div class="row">
                                                                <strong class="col-sm-3 col-form-label">Kategori Kegiatan</strong>
                                                                <label class="col-sm-9 col-form-label">
                                                                    {{ item.kategori_kegiatan }}
                                                                </label>
                                                            </div>
                                                            <div class="row">
                                                                <strong class="col-sm-3 col-form-label">Jenis Kegiatan</strong>
                                                                <label class="col-sm-9 col-form-label">
                                                                    {{ item.jenis_kegiatan }}
                                                                </label>
                                                            </div>
                                                            <div class="row">
                                                                <strong class="col-sm-3 col-form-label">Tahun</strong>
                                                                <label class="col-sm-9 col-form-label">
                                                                    {{ item.tahun }}
                                                                </label>
                                                            </div>
                                                            <div class="row">
                                                                <strong class="col-sm-3 col-form-label">Semester</strong>
                                                                <label class="col-sm-9 col-form-label text-capitalize">
                                                                    {{ item.semester }}
                                                                </label>
                                                            </div>
                                                            <div class="row">
                                                                <strong class="col-sm-3 col-form-label">Valid Point</strong>
                                                                <label class="col-sm-9 col-form-label">
                                                                    {{ item.valid_point }}
                                                                </label>
                                                            </div>
                                                            <div class="row">
                                                                <strong class="col-sm-3 col-form-label">Valid Point</strong>
                                                                <a :href="item.bukti_url" target="_blank" class="col-sm-9 col-form-label">
                                                                    {{ item.bukti_url }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 d-flex justify-content-center align-items-center">
                                                <button type="button" class="btn btn-sm btn-primary d-inline-flex justify-content-center align-items-center" data-toggle="modal" data-target="#exampleModal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 float-right">Validasi Semua Portofolio</button>
                    <router-link :to="{ name: 'perluValidasi' }" class="btn btn-light mt-3">Kembali</router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            portofolio: {},
            portofolioPoint: [],
        };
    },
    mounted() {
        axios.get("/portofolio/api/portofolio/byNim/" + this.$route.params.nim).then((response) => {
            this.portofolio = response.data.data;
        });
    },
    methods: {
        validasi: function (e) {
            e.preventDefault();
            this.$swal
                .fire({
                    title: "Apakah kamu yakin?",
                    text: "Jika anda validasi, maka data tidak akan bisa diperbarui lagi.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Validasi",
                    cancelButtonText: "Batal",
                })
                .then((result) => {
                    for (let i in this.portofolio.perluValidasi) {
                        let formData = new FormData();
                        formData.append("valid_point", this.portofolioPoint[i]);
                        if (result.value) {
                            axios.post("/portofolio/api/portofolio/validasi/" + this.portofolio.perluValidasi[i].id, formData);
                        }
                    }
                    this.$swal.fire({ title: "Success!", text: "Portofolio Tervalidasi", icon: "success", timer: 1000 });
                    this.$router.push({ name: "perluValidasi" });
                });
        },
        checkExtension: function (src) {
            return src.split(".").pop();
        },
    },
};
</script>

<style scoped>
.th-width {
    width: 150px;
}
</style>

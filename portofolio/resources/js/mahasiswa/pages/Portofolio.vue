<template>
    <div>
        <loading :active.sync="isLoading"></loading>
        <div class="col-md-12 mb-3 d-flex justify-content-between align-items-center">
            <h3>Data Portofolio Mahasiswa</h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <router-link :to="{ name: 'portofolioCreate' }" class="btn btn-primary mb-3">
                        <i class="icon-plus mr-2"></i>
                        Tambah Data
                    </router-link>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama Kegiatan</th>
                                    <th class="text-center">Penyelenggara</th>
                                    <th class="text-center">Point</th>
                                    <th class="text-center" width="10">Status</th>
                                    <th class="text-center" width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="portofolio.data.length !== 0">
                                    <tr v-for="(item, index) in portofolio.data" :key="index">
                                        <td class="text-center">{{ item.nama_kegiatan }}</td>
                                        <td class="text-center">{{ item.penyelenggara }}</td>
                                        <td class="text-center">{{ item.valid_point }}</td>
                                        <td class="text-center">
                                            <div v-if="item.status == 0" class="btn btn-sm btn-danger d-flex justify-content-center align-items-center">
                                                <i class="ti-close"></i>
                                            </div>
                                            <div v-else class="btn btn-sm btn-success d-flex justify-content-center align-items-center">
                                                <i class="ti-check"></i>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" :data-target="'#exampleModal' + index">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <i class="ti-eye"></i>
                                                </div>
                                            </button>
                                            <button @click="redirectCheck(item.id)" class="btn btn-sm btn-warning" type="button">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <i class="ti-marker-alt"></i>
                                                </div>
                                            </button>
                                            <button @click="deleteData(item.id)" v-if="item.status == 0" class="btn btn-sm btn-danger">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <i class="ti-trash"></i>
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
                                                                    <strong class="col-sm-3 col-form-label">Bukti</strong>
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
                                </template>
                                <tr v-else>
                                    <td colspan="5" class="text-center">Belum Ada Data Portofolio</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <pagination :data="portofolio" @pagination-change-page="getResults" align="center"></pagination>
                        </div>
                    </div>
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
            portofolio: {},
            filterClass: false,
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults: function (page = 1) {
            axios.get("/portofolio/api/portofolio?page=" + page).then((response) => {
                this.portofolio = response.data;
            });
        },
        deleteData: function (id) {
            this.$swal
                .fire({
                    title: "Apakah kamu yakin?",
                    text: "Jika kamu hapus, maka data tidak akan kembali lagi.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Delete",
                    cancelButtonText: "Batal",
                })
                .then((result) => {
                    if (result.value) {
                        this.isLoading = true;
                        this.isSuccess = false;
                        let uri = `/portofolio/api/portofolio/${id}`;
                        this.axios
                            .delete(uri)
                            .then((response) => {
                                this.isSuccess = true;
                                this.$swal.fire({ title: "Success!", text: "Angkatan deleted successfully", icon: "success", timer: 1000 });
                                this.portofolio.data.splice(this.portofolio.data.indexOf(id), 1);
                            })
                            .finally(() => {
                                this.isLoading = false;
                            });
                    }
                });
        },
        redirectCheck: function (id) {
            axios.get("/portofolio/api/portofolio/" + id).then((response) => {
                if (response.data.data.status === 0) {
                    this.$router.push({ name: "portofolioEdit", params: { id: id } });
                } else {
                    this.$swal
                        .fire({
                            title: "Apakah kamu yakin?",
                            text: "Jika anda mengedit data yang sudah tervalidasi, maka data point akan tereset ke 0 kembali.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yakin",
                            cancelButtonText: "Batal",
                        })
                        .then((result) => {
                            if (result.value) {
                                this.$router.push({ name: "portofolioEdit", params: { id: id } });
                            }
                        });
                }
            });
        },
        // checkExtension: function (src) {
        //     return src.split(".").pop();
        // },
    },
};
</script>

<style scoped>
.select-text {
    color: #1f1f1f;
}
</style>


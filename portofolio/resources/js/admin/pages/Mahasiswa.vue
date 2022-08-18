<template>
    <div>
        <div class="col mb-3 ml-2">
            <h3>Mahasiswa</h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <router-link :to="{ name: 'mahasiswaCreate' }" class="btn btn-primary mb-3">
                        <i class="icon-plus mr-2"></i>
                        Tambah Data
                    </router-link>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Pembimbing Akademik</th>
                                    <th>Fakultas</th>
                                    <th>Jurusan</th>
                                    <th>Program Studi</th>
                                    <th>Angkatan</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in mahasiswa.data" :key="index">
                                    <td>{{ item.nama }}</td>
                                    <td>{{ item.nim }}</td>
                                    <td>{{ item.pembimbing_akademik }}</td>
                                    <td>{{ item.fakultas }}</td>
                                    <td>{{ item.jurusan }}</td>
                                    <td>{{ item.prodi }}</td>
                                    <td>{{ item.angkatan }}</td>
                                    <td class="text-center">
                                        <div class="d-inline btn-group">
                                            <router-link :to="{ name: 'mahasiswaEdit', params: { id: item.id } }" class="btn btn-sm btn-warning rounded-left">
                                                <i class="ti-pencil-alt"></i>
                                            </router-link>
                                            <button @click="deleteData(item.id)" class="btn btn-sm btn-danger rounded-right" type="submit">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <pagination :data="mahasiswa" @pagination-change-page="getResults" align="center"></pagination>
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
            mahasiswa: {},
        };
    },
    mounted() {
        this.getResults();
    },
    methods: {
        getResults: function (page = 1) {
            axios.get("/portofolio/api/mahasiswa?page=" + page).then((response) => {
                this.mahasiswa = response.data;
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
                        let uri = `/portofolio/api/mahasiswa/${id}`;
                        this.axios.delete(uri).then((response) => {
                            this.$swal.fire({ title: "Success!", text: "Mahasiswa deleted successfully", icon: "success", timer: 1000 });
                            // this.products.data.splice(this.products.data.indexOf(id), 1);
                        });
                        this.showAllData();
                    }
                });
        },
    },
};
</script>

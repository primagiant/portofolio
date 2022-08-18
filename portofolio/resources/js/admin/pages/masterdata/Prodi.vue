<template>
    <div>
        <div class="col mb-3 ml-2">
            <h3>Program Studi</h3>
        </div>
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <router-link :to="{ name: 'prodiCreate' }" class="btn btn-primary mb-3">
                        <i class="icon-plus mr-2"></i>
                        Tambah Data
                    </router-link>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Program Studi</th>
                                    <th>Nama Jurusan</th>
                                    <th>Nama Fakultas</th>
                                    <th style="width: 16.66%">Deskripsi</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in prodi.data" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.nama_prodi }}</td>
                                    <td>{{ item.fakultas }}</td>
                                    <td>{{ item.jurusan }}</td>
                                    <td>{{ item.deskripsi }}</td>
                                    <td class="text-center">
                                        <div class="d-inline btn-group">
                                            <router-link :to="{ name: 'prodiEdit', params: { id: item.id } }" class="btn btn-sm btn-warning rounded-left">
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
                            <pagination :data="prodi" @pagination-change-page="showAllData" align="center"></pagination>
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
            prodi: {},
        };
    },
    mounted() {
        this.showAllData();
    },
    methods: {
        showAllData: function (page = 1) {
            axios.get("/portofolio/api/prodi?page=" + page).then((response) => {
                this.prodi = response.data;
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
                        let uri = `/portofolio/api/prodi/${id}`;
                        this.axios.delete(uri).then((response) => {
                            this.$swal.fire({ title: "Success!", text: "Prodi deleted successfully", icon: "success", timer: 1000 });
                        });
                        this.showAllData();
                    }
                });
        },
    },
};
</script>

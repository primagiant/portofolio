<template>
    <div>
        <div class="col mb-3 ml-2">
            <h3>Jurusan</h3>
        </div>
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <router-link :to="{ name: 'jurusanCreate' }" class="btn btn-primary mb-3">
                        <i class="icon-plus mr-2"></i>
                        Tambah Data
                    </router-link>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Jurusan</th>
                                    <th>Nama Fakultas</th>
                                    <th style="width: 16.66%">Deskripsi</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in jurusan.data" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.nama_jurusan }}</td>
                                    <td>{{ item.fakultas }}</td>
                                    <td>{{ item.deskripsi }}</td>
                                    <td class="text-center">
                                        <div class="d-inline btn-group">
                                            <router-link :to="{ name: 'jurusanEdit', params: { id: item.id } }" class="btn btn-sm btn-warning rounded-left">
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
                            <pagination :data="jurusan" @pagination-change-page="showAllData" align="center"></pagination>
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
            jurusan: {},
        };
    },
    mounted() {
        this.showAllData();
    },
    methods: {
        showAllData: function (page = 1) {
            axios.get("/portofolio/api/jurusan?page=" + page).then((response) => {
                this.jurusan = response.data;
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
                        let uri = `/portofolio/api/jurusan/${id}`;
                        this.axios.delete(uri).then((response) => {
                            this.$swal.fire({ title: "Success!", text: "Jurusan deleted successfully", icon: "success", timer: 1000 });
                        });
                        this.showAllData();
                    }
                });
        },
    },
};
</script>

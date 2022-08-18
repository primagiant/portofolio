<template>
    <div>
        <div class="col-md-12 mb-3">
            <h3>Perlu Validasi</h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Program Studi</th>
                                    <th width="50" class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="mahasiswa.data.length != 0">
                                    <tr v-for="(item, index) in mahasiswa.data" :key="index">
                                        <td>{{ item.nama }}</td>
                                        <td>{{ item.nim }}</td>
                                        <td>{{ item.prodi }}</td>
                                        <td>
                                            <router-link :to="{ name: 'detailPerluValidasi', params: { nim: item.nim } }" class="btn btn-sm btn-primary" type="submit">
                                                <div class="d-flex justify-content-center align-items-center px-2">
                                                    <i class="ti-eye"></i>
                                                    <span class="ml-2">Detail</span>
                                                </div>
                                            </router-link>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr>
                                        <td class="text-center" colspan="4">Tidak Ada Data Yang Perlu Divalidasi</td>
                                    </tr>
                                </template>
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
    created() {
        this.getResults();
    },
    methods: {
        getResults: function (page = 1) {
            axios.get("/portofolio/api/pembimbingakademik/invalidMahasiswa?page=" + page).then((response) => {
                this.mahasiswa = response.data;
            });
        },
    },
};
</script>

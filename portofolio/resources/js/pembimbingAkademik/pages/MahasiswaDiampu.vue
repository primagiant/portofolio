<template>
    <div>
        <div class="col-md-12 mb-3">
            <h3>Mahasiswa Diampu</h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th class="text-center">NIM</th>
                                    <th class="text-center">Program Studi</th>
                                    <th class="text-center">Skor Terkumpul</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="mahasiswa.data.length != 0">
                                    <tr v-for="(item, index) in mahasiswa.data" :key="index">
                                        <td>{{ item.nama }}</td>
                                        <td class="text-center">{{ item.nim }}</td>
                                        <td class="text-center">{{ item.prodi }}</td>
                                        <td class="text-center">
                                            {{ item.totalSkor }}
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr>
                                        <td class="text-center" colspan="4">Belum Ada Mahasiswa</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <pagination :data="mahasiswa" @pagination-change-page="showAllData" align="center"></pagination>
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
            axios.get("/portofolio/api/mahasiswa?page=" + page).then((response) => {
                this.mahasiswa = response.data;
            });
        },
    },
};
</script>

<template>
    <div>
        <div class="col-md-12 mb-3">
            <h3>Detail Portofolio Valid</h3>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Penyelenggara</th>
                                    <th class="text-center" width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in portofolio.sudahValidasi" :key="index">
                                    <td>{{ item.nama_kegiatan }}</td>
                                    <td class="text-center">{{ item.tahun }}</td>
                                    <td class="text-center">{{ item.penyelenggara }}</td>
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
                    <router-link :to="{ name: 'sudahValidasi' }" type="button" class="btn btn-light float-right mt-3">Kembali</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            portofolio: {},
        };
    },
    mounted() {
        axios.get("/portofolio/api/portofolio/byNim/" + this.$route.params.nim).then((response) => {
            this.portofolio = response.data.data;
        });
    },
    methods: {
        checkExtension: function (src) {
            return src.split(".").pop();
        },
    },
};
</script>

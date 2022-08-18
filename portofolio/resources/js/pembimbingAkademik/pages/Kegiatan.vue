<template>
    <div>
        <div class="col-md-12 mb-3">
            <h3>Kegiatan</h3>
        </div>
        <div class="col-md-12 rounded">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <!-- loop 1 -->
                        <li v-for="(kategori_kegiatan, index) in kegiatan.data" :key="index" class="list-group-item">
                            <strong>{{ kategori_kegiatan.nama }}</strong>
                            <!-- loop 2 -->
                            <ul v-for="(jenis_kegiatan, index) in kategori_kegiatan.jenis_kegiatan" :key="index" class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ jenis_kegiatan.nama }}</span>
                                    <strong>{{ jenis_kegiatan.ref_point }}</strong>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="mt-3">
                        <pagination :data="kegiatan" @pagination-change-page="getResults" align="center"></pagination>
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
            kegiatan: {},
        };
    },
    mounted() {
        this.getResults();
    },
    methods: {
        getResults: function (page = 1) {
            axios.get("/portofolio/api/kegiatan?page=" + page).then((response) => {
                this.kegiatan = response.data;
            });
        },
    },
};
</script>

<template>
    <div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome {{ mhs.nama }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale csr-pointer">
                            <div class="card-body">
                                <p class="mb-4">Point Terkumpul</p>
                                <p class="fs-30 mb-2">{{ mhs.totalSkor }}</p>
                                <p>Portofolio</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue csr-pointer">
                            <div class="card-body">
                                <p class="mb-4">Total Portofolio</p>
                                <p class="fs-30 mb-2">{{ totalPortofolio }}</p>
                                <p>Portofolio</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Sudah Tervalidasi</p>
                                <p class="fs-30 mb-2">{{ valid }}</p>
                                <p>Portofolio</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Belum Tervalidasi</p>
                                <p class="fs-30 mb-2">{{ belumValid }}</p>
                                <p>Mahasiswa</p>
                            </div>
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
            portofolio: {},
            mhs: {},
            belumValid: 0,
            valid: 0,
            totalPortofolio: 0,
        };
    },
    mounted() {
        axios.get("/portofolio/api/portofolio").then((response) => {
            this.portofolio = response.data.data;
            this.portofolio.forEach((e) => {
                if (e.status === 1) {
                    this.valid++;
                } else {
                    this.belumValid++;
                }
                this.totalPortofolio++;
            });
        });
        axios.get("/portofolio/api/mahasiswa").then((response) => {
            this.mhs = response.data.data;
        });
    },
};
</script>

<template>
    <div>
        <div class="col mb-3 ml-2">
            <h3>Daftar Mahasiswa</h3>
        </div>
        <form @submit.prevent="assignMahasiswa">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" v-model="checkAll" @click="select()" /></th>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th>Fakultas</th>
                                        <th>Jurusan</th>
                                        <th>Program Studi</th>
                                        <th>Semester</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in mahasiswa.data" :key="index">
                                        <td><input type="checkbox" :value="item.id" @change="updateSelected()" v-model="selected" /></td>
                                        <td>{{ item.nama }}</td>
                                        <td>{{ item.nim }}</td>
                                        <td>{{ item.fakultas }}</td>
                                        <td>{{ item.jurusan }}</td>
                                        <td>{{ item.prodi }}</td>
                                        <td>{{ item.angkatan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary float-right mt-3">Tetapkan PA</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            mahasiswa: {},
            selected: [],
            checkAll: false,
        };
    },
    mounted() {
        this.showAllData();
    },
    methods: {
        showAllData: function () {
            axios.get("/portofolio/api/mahasiswa").then((response) => {
                for (let i = 0; i < response.data.data.length; i++) {
                    if (response.data.data[i].pembimbing_akademik !== "Data Belum Ada") {
                        response.data.data.splice(i, 1);
                        i--;
                    }
                }
                this.mahasiswa = response.data;
            });
        },
        select() {
            this.selected = [];
            if (!this.checkAll) {
                for (let i in this.mahasiswa.data) {
                    this.selected.push(this.mahasiswa.data[i].id);
                }
            }
        },
        updateSelected() {
            if (this.selected.length == this.mahasiswa.data.length) {
                this.checkAll = true;
            } else {
                this.checkAll = false;
            }
            console.log(this.selected);
        },
        assignMahasiswa: function (e) {
            e.preventDefault();
            this.$swal
                .fire({
                    title: "Apakah anda yakin?",
                    text: "Jika anda menetapkan pembimbing akademik, maka data tidak akan bisa ubah kembali.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Tetapkan",
                    cancelButtonText: "Batal",
                })
                .then((result) => {
                    if (result.value) {
                        let formdata = new FormData();
                        formdata.append("pembimbing_akademik_id", this.$route.params.id);
                        for (let i in this.selected) {
                            axios.post("/portofolio/api/mahasiswa/assign/" + this.selected[i], formdata).then((response) => {
                                this.$swal.fire({ title: "Success!", text: "Pembimbing Akademik Berhasil Ditetapkan", icon: "success", timer: 1000 });
                            });
                        }
                    }
                    this.$router.push({ name: "pembimbingakademik" });
                });
        },
    },
};
</script>

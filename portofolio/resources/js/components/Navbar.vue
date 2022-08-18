<template>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="">
                <img :src="'/portofolio/images/logo-mini.svg'" alt="logo" />
                <span>Portofolio</span>
            </a>
            <a class="navbar-brand brand-logo-mini" href="">
                <img :src="'/portofolio/images/logo-mini.svg'" alt="logo" />
            </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img :src="'/portofolio/images/default.svg'" alt="profile" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <button @click.prevent="logout" class="dropdown-item">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </button>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="icon-menu"></span>
            </button>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        };
    },
    methods: {
        logout: function () {
            axios.post("/portofolio/logout").then((response) => {
                window.location.href = "/portofolio/login";
            });
        },
    },
};
</script>

<style scoped>
.navbar .brand-logo img {
    width: 35px;
    height: 35px;
}
.navbar .brand-logo span {
    font-family: "Nunito", sans-serif;
    font-weight: 700;
    font-size: 20px;
    margin-left: 6px;
}
</style>

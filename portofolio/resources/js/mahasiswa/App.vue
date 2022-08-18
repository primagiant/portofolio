<template>
    <div class="container-scroller">
        <navbar></navbar>
        <div class="container-fluid page-body-wrapper">
            <sidebar></sidebar>

            <div class="main-panel">
                <div class="content-wrapper">
                    <router-view></router-view>
                </div>

                <footer></footer>
            </div>
        </div>
    </div>
</template>

<script>
import Footer from "../components/Footer.vue";
import Navbar from "../components/Navbar.vue";
import Sidebar from "./components/Sidebar.vue";
export default {
    components: {
        Navbar,
        Sidebar,
        Footer,
    },
};
</script>
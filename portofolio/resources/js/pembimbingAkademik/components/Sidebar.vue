<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item" :class="{ active: $route.matched.some(({ name }) => name === 'dashboard') }">
                <router-link :to="{ name: 'dashboard' }" class="nav-link">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Beranda</span>
                </router-link>
            </li>

            <li class="nav-item" :class="{ active: $route.matched.some(({ name }) => name === 'kegiatan') }">
                <router-link :to="{ name: 'kegiatan' }" class="nav-link">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Kegiatan</span>
                </router-link>
            </li>

            <li class="nav-item" :class="{ active: $route.matched.some(({ name }) => name === 'mahasiswaDiampu') }">
                <router-link :to="{ name: 'mahasiswaDiampu' }" class="nav-link">
                    <i class="icon-folder menu-icon"></i>
                    <span class="menu-title">Mahasiswa</span>
                </router-link>
            </li>

            <li class="nav-item" :class="{ active: $route.matched.some(({ name }) => name === 'perluValidasi') }">
                <router-link :to="{ name: 'perluValidasi' }" class="nav-link">
                    <i class="icon-square-cross menu-icon"></i>
                    <span class="menu-title">Belum Validasi</span>
                </router-link>
            </li>

            <li class="nav-item" :class="{ active: $route.matched.some(({ name }) => name === 'sudahValidasi') }">
                <router-link :to="{ name: 'sudahValidasi' }" class="nav-link">
                    <i class="icon-square-check menu-icon"></i>
                    <span class="menu-title">Sudah Validasi</span>
                </router-link>
            </li>
        </ul>
    </nav>
</template>
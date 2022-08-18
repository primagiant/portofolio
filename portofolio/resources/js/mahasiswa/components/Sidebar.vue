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

            <li class="nav-item" :class="{ active: $route.matched.some(({ name }) => name === 'portofolio') }">
                <router-link :to="{ name: 'portofolio' }" class="nav-link">
                    <i class="ti-user menu-icon"></i>
                    <span class="menu-title">Portofolio</span>
                </router-link>
            </li>
        </ul>
    </nav>
</template>
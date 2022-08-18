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

            <li class="nav-item" :class="{ active: $route.matched.some(({ name }) => name === 'mahasiswa') }">
                <router-link :to="{ name: 'mahasiswa' }" class="nav-link">
                    <i class="ti-user menu-icon"></i>
                    <span class="menu-title">Mahasiswa</span>
                </router-link>
            </li>

            <li class="nav-item" :class="{ active: $route.matched.some(({ name }) => name === 'pembimbingakademik') }">
                <router-link :to="{ name: 'pembimbingakademik' }" class="nav-link">
                    <i class="ti-id-badge menu-icon"></i>
                    <span class="menu-title">
                        Pembimbing
                        <br />
                        Akademik
                    </span>
                </router-link>
            </li>

            <li class="nav-item">
                <div class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="ti-package menu-icon"></i>
                    <span class="menu-title">Master Data</span>
                    <i class="menu-arrow"></i>
                </div>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <router-link :to="{ name: 'fakultas' }" class="nav-link">Fakultas</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'jurusan' }" class="nav-link">Jurusan</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'prodi' }" class="nav-link">Program Studi</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'angkatan' }" class="nav-link">Angkatan</router-link>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</template>
<template>
    <div class="container-fluid side-bar">
        <header class="logo"><nuxt-link to="/"> IT Support </nuxt-link></header>

        <nav>
            <ul>
                <!-- Picking category -->
                <li class="nav-cat">
                    <div
                        class="nav-head"
                        :class="{ highlight: toggle.picking }"
                        @click="toggleList('picking')"
                    >
                        <span class="icon">
                            <font-awesome-icon
                                icon="fa-solid fa-mobile-screen-button"
                            />
                        </span>
                        <span>Picking</span>

                        <span class="icon">
                            <font-awesome-icon
                                icon="fa-solid fa-chevron-right"
                            />
                        </span>
                    </div>
                    <transition name="slide">
                        <ul v-if="toggle.picking" class="sub-list">
                            <nuxt-link to="/picking">
                                <li>Picking</li>
                            </nuxt-link>
                            <nuxt-link to="/picking/telefon">
                                <li>Telefoane</li>
                            </nuxt-link>
                            <nuxt-link to="/picking/scaner">
                                <li>Scanere</li>
                            </nuxt-link>
                            <nuxt-link to="/picking/service">
                                <li>Service</li>
                            </nuxt-link>
                            <nuxt-link to="/picking/istoric_service">
                                <li>Istoric Service</li>
                            </nuxt-link>
                            <nuxt-link to="/picking/sim">
                                <li>Sim</li>
                            </nuxt-link>
                            <nuxt-link to="/picking/inventar">
                                <li>Inventar</li>
                            </nuxt-link>
                            <nuxt-link to="/picking/cuseta">
                                <li>Cusete</li>
                            </nuxt-link>
                        </ul>
                    </transition>
                </li>
                <!-- Device category -->
                <li class="nav-cat">
                    <div
                        class="nav-head"
                        :class="{ highlight: toggle.devices }"
                        @click="toggleList('devices')"
                    >
                        <span class="icon"
                            ><font-awesome-icon icon="fa-solid fa-desktop"
                        /></span>
                        <span>Devices</span>
                        <span class="icon">
                            <font-awesome-icon
                                icon="fa-solid fa-chevron-right"
                            />
                        </span>
                    </div>
                    <transition name="slide">
                        <ul v-if="toggle.devices" class="sub-list">
                            <nuxt-link to="/devices">
                                <li>Computere</li>
                            </nuxt-link>
                            <nuxt-link to="/devices/network">
                                <li>Network</li>
                            </nuxt-link>
                            <nuxt-link to="/devices/imprimante">
                                <li>Imprimante</li>
                            </nuxt-link>
                            <nuxt-link to="/devices/scanere">
                                <li>Scanere Arhivare</li>
                            </nuxt-link>
                        </ul>
                    </transition>
                </li>
                <!-- Network category -->
                <li class="nav-cat">
                    <div
                        class="nav-head"
                        :class="{ highlight: toggle.network }"
                        @click="toggleList('network')"
                    >
                        <span class="icon"
                            ><font-awesome-icon
                                icon="fa-solid fa-network-wired"
                        /></span>
                        <span>Network</span>
                        <span class="icon">
                            <font-awesome-icon
                                icon="fa-solid fa-chevron-right"
                            />
                        </span>
                    </div>
                    <transition name="slide">
                        <ul v-if="toggle.network" class="sub-list">
                            <nuxt-link to="/network">
                                <li>Conexiuni</li>
                            </nuxt-link>
                            <nuxt-link to="/network/maps">
                                <li>Harti</li>
                            </nuxt-link>
                            <nuxt-link to="/devices/racks">
                                <li>Rackuri</li>
                            </nuxt-link>
                        </ul>
                    </transition>
                </li>
                <!-- Tichete category -->
                <li class="nav-cat" @click="toggleList('tichete')">
                    <div
                        class="nav-head"
                        :class="{ highlight: toggle.tichete }"
                    >
                        <span class="icon">
                            <font-awesome-icon icon="fa-solid fa-list-check" />
                        </span>

                        <span>Tichete</span>

                        <span>
                            <font-awesome-icon
                                icon="fa-solid fa-chevron-right"
                            />
                        </span>
                    </div>
                    <transition name="slide">
                        <ul v-if="toggle.tichete" class="sub-list">
                            <nuxt-link to="/tichet">
                                <li>Toate</li>
                            </nuxt-link>
                            <nuxt-link to="/activ">
                                <li>Active</li>
                            </nuxt-link>
                            <nuxt-link to="/mine">
                                <li>Tichetele Mele</li>
                            </nuxt-link>
                            <nuxt-link to="/inchis">
                                <li>Tichete Inchise</li>
                            </nuxt-link>
                        </ul>
                    </transition>
                </li>
                <!-- Supraveghere category -->
                <li class="nav-cat" @click="toggleList('supraveghere')">
                    <div
                        class="nav-head"
                        :class="{ highlight: toggle.supraveghere }"
                    >
                        <span class="icon">
                            <font-awesome-icon icon="fa-solid fa-video" />
                        </span>

                        <span>Supraveghere</span>

                        <span class="icon">
                            <font-awesome-icon
                                icon="fa-solid fa-chevron-right"
                            />
                        </span>
                    </div>
                    <transition name="slide">
                        <ul v-if="toggle.supraveghere" class="sub-list">
                            <nuxt-link to="/supraveghere/dvrnvr">
                                <li>NVR</li>
                            </nuxt-link>
                            <nuxt-link to="/supraveghere/dvrnvr">
                                <li>DVR</li>
                            </nuxt-link>
                            <nuxt-link to="/supraveghere/camere">
                                <li>Camere</li>
                            </nuxt-link>
                        </ul>
                    </transition>
                </li>
                <!-- Coletarie category -->
                <li class="nav-cat">
                    <div
                        class="nav-head"
                        :class="{ highlight: toggle.coletarie }"
                    >
                        <nuxt-link to="/coletarie">
                            <span class="icon"
                                ><font-awesome-icon
                                    icon="fa-solid fa-boxes-stacked"
                            /></span>

                            <span>Coletarie</span>
                        </nuxt-link>
                    </div>
                </li>
                <!-- How 2 category -->
                <li class="nav-cat">
                    <div class="nav-head">
                        <nuxt-link to="/how2">
                            <span class="icon">
                                <font-awesome-icon
                                    icon="fa-solid fa-graduation-cap"
                                />
                            </span>
                            <span>How 2</span>
                        </nuxt-link>
                    </div>
                </li>
                <li class="nav-cat">
                    <div class="nav-head">
                        <nuxt-link to="/depozit">
                            <span class="icon"
                                ><font-awesome-icon
                                    icon="fa-solid fa-warehouse"
                            /></span>
                            <span>Depozite</span>
                        </nuxt-link>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    data: () => ({
        toggle: {
            picking: false,
            tichete: false,
            pc: false,
            scanere: false,
            imprimante: false,
            supraveghere: false,
            coletarie: false,
            network: false,
            devices: false,
        },
    }),
    methods: {
        toggleList(el) {
            this.toggle[el] = !this.toggle[el]
        },
    },
}
</script>

<style lang="scss">
.side-bar {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    flex-direction: column;
    background-color: $nav-bk;
    color: $nav-color;
    font-family: 'Roboto', sans-serif;
    z-index: 500;

    .logo {
        font-size: 25px;
        padding: 15px 20px;
    }
    a {
        color: $nav-color;
        text-decoration: none;
    }
    .svg {
        width: 20px;
    }
    .icon {
        svg {
            max-width: 20px;
        }
    }
}

nav {
    width: 100%;
    .nav-cat {
        cursor: pointer;

        .nav-head {
            display: flex;
            align-items: center;
            padding: 15px;
            z-index: 1000;

            span {
                min-width: 14px;
                font-size: 16px;
            }

            span:first-child {
                margin-right: 15px;
                font-size: 16px;
            }
            span:nth-child(3) {
                margin-left: auto;
                font-size: 10px;
                max-width: 20px;
                width: 9px;
            }
            a {
                display: flex;
            }
        }
        .nav-head:hover {
            color: white;
            transition: 0.25s ease;
            a {
                color: white;
                transition: 0.25s ease;
            }
        }
        .sub-list {
            list-style-type: none;
            margin-left: 46px;
            font-size: 15px;
            z-index: 1;
            li {
                padding: 7px;
            }
            li:hover {
                color: rgba($button-bk, 0.9);
                transition: 0.25s ease;
            }
        }
    }
}
.highlight {
    border-left: 2px solid $button-bk;
    background: $button-bk;
    background: linear-gradient(
        90deg,
        rgba($button-bk, 0.16850490196078427) 0%,
        rgba(0, 0, 0, 0) 100%
    );
    color: white;
}
.slide-enter-active,
.slide-leave-active {
    transition: 0.25s ease;
}

.slide-enter,
.slide-leave-to {
    max-height: 0;
    opacity: 0;
}
.slide-enter-to,
.slide-leave {
    max-height: 500px;
    opacity: 1;
}
</style>

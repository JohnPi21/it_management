<template>
    <div class="layout">
        <Popup v-if="$store.state.ui['info']" />
        <LoadingBar v-if="loading" />
        <div class="nav" :class="{ display_nav: $store.state.ui['navbar'] }">
            <NavBar v-if="$store.state.auth.online" />
        </div>
        <div
            class="view"
            :class="{
                nav_active: $store.state.ui['navbar'],
                full_screen: !$store.state.auth.online,
            }"
        >
            <TopNav v-if="$store.state.auth.online" />
            <Nuxt />
        </div>
    </div>
</template>

<script>
import NavBar from '~/components/navbars/NavBar.vue'
import TopNav from '~/components/navbars/TopNav.vue'
import LoadingBar from '~/components/ui/LoadingBar.vue'

export default {
    components: {
        LoadingBar,
        NavBar,
        TopNav,
    },
    data: () => ({
        loading: true,
    }),
    mounted() {
        setTimeout(() => {
            this.loading = false
        }, 500)
        this.$init()
        this.$nextTick(() => {
            this.onResize()
            window.addEventListener('resize', this.onResize)
        })
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize)
    },

    methods: {
        onResize() {
            if (window.innerWidth <= 576) {
                this.$store.commit('set_ui', ['navbar', false])
            } else {
                this.$store.commit('set_ui', ['navbar', true])
            }
        },
    },
}
</script>
<style lang="css">
html {
    font-family: 'Helvetica Neue', 'Source Sans Pro', -apple-system,
        BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
    box-sizing: border-box;
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
}

*,
*::before,
*::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
::-webkit-scrollbar {
    display: none;
}

.layout {
    position: absolute;
    display: flex;
    padding: 0;
    width: 100vw;
    height: 100vh;
}
.nav {
    display: none;
    position: fixed;
    width: 250px;
    max-width: 250px;
    height: 100%;
    z-index: 100;
}
.view {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
}
.nav_active {
    margin-left: 250px;
    max-width: calc(100% - 250px);
}
.display_nav {
    display: block;
}
.full_screen {
    width: 100%;
    margin: 0px;
}
</style>

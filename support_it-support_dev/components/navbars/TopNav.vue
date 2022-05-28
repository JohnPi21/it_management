<template>
    <div class="top-nav" :class="{ side_active: $store.state.ui['navbar'] }">
        <span class="burger" @click="$store.commit('toggle', 'navbar')">
            <font-awesome-icon :icon="['fas', 'bars']" class="svg" />
        </span>
        <div class="r-side">
            <span>
                <font-awesome-icon
                    :icon="['fas', 'sign-out-alt']"
                    class="svg"
                    @click="logout()"
                />
            </span>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        logout() {
            this.$logout()
            window.$nuxt.$router.push('/login')
        },
    },
}
</script>

<style lang="scss">
.top-nav {
    position: fixed;
    display: flex;
    align-items: center;
    min-height: 50px;
    width: 100%;
    background-color: $top-nav-bk;
    color: $nav-color;
    font-size: 18px;
}
.burger {
    margin-right: auto;
}
.r-side {
    margin-left: auto;
}
.burger,
.r-side {
    padding: 15px;
    cursor: pointer;
}
.burger:hover,
.r-side:hover {
    color: white;
    transition: 0.25s ease;
}
.side_active {
    width: calc(100% - 250px);
}
</style>

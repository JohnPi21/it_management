export default async ({ app, store }, inject) => {
    inject('auth', app.store.state.auth)
    inject('init', async function init() {
        if (!app.$auth.online) {
            await app.$axios
                .$get('auth/init', {
                    withCredentials: true,
                })
                .then((response) => {
                    store.commit('set_auth', response)
                    if ('0' in response) {
                        window.$nuxt.$router.push('/login')
                        return
                    }
                })
        }
    })
    inject('logout', async function logout() {
        if (app.store.state.auth.online) {
            await app.$axios
                .$get('auth/logout', {
                    withCredentials: true,
                })
                .then((response) => {
                    this.$notification(response)
                    store.commit('set_auth', {})
                })
        }
    })
}

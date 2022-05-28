export default {
    // Target: https://go.nuxtjs.dev/config-target
    target: 'server',
    server: {
        port: '3030',
    },
    // Global page headers: https://go.nuxtjs.dev/config-head
    head: {
        title: 'Support IT',
        htmlAttrs: {
            lang: 'en',
        },
        meta: [
            { charset: 'utf-8' },
            {
                name: 'viewport',
                content: 'width=device-width, initial-scale=1',
            },
            { hid: 'description', name: 'description', content: '' },
        ],
        script: [
            {
                hid: 'stripe',
                src: 'https://accounts.google.com/gsi/client',
                defer: true,
                async: true,
            },
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
            { rel: 'preconnect', href: 'https://fonts.gstatic.com/' },
        ],
    },
    // Modules: https://go.nuxtjs.dev/config-modules
    modules: [
        // 'https://go.nuxtjs.dev/axios',
        '@nuxtjs/axios',
    ],

    // Axios module configuration: https://go.nuxtjs.dev/config-axios
    axios: {
        baseURL: 'https://api.alexwork.xyz/',
        common: {
            Accept: 'application/json, text/plain, */*',
        },
        headers: {
            'back-access': 'inside',
            'Content-Type': 'application/json',
        },
        credentials: true,
    },
    // Global CSS: https://go.nuxtjs.dev/config-css
    css: [
        '~assets/style/css/bootstrap-grid.min.css',
        '~assets/style/scss/main-table.scss',
        '~assets/style/scss/globals.scss',
        '~assets/style/scss/page-style.scss',
        '~assets/style/scss/modals.scss',
        '@fortawesome/fontawesome-svg-core/styles.css',
    ],

    // Auto import components: https://go.nuxtjs.dev/config-components
    components: true,

    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: [
        // https://go.nuxtjs.dev/eslint
        '@nuxtjs/eslint-module',
        '@nuxtjs/style-resources',
        '@nuxtjs/google-fonts',
    ],
    googleFonts: {
        prefetch: true,
        families: {
            Roboto: true,
            Sarabun: true,
            Lato: true,
        },
    },

    styleResources: {
        scss: [
            '~assets/style/scss/mixins.scss',
            '~assets/style/scss/variables.scss',
        ],
    },

    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [
        '~/plugins/tableFunctions.js',
        '~/plugins/drive.client.js',
        '~/plugins/nuxtFunctions.js',
        '~/plugins/calendar.client.js',
        '~/plugins/quill.client.js',
        '~/plugins/fontawesome.js',
        '~/plugins/auth.js',
    ],

    router: {
        middleware: ['auth'],
    },

    // Build Configuration: https://go.nuxtjs.dev/config-build
    build: {
        filenames: {
            app: ({ isDev }) => (isDev ? '[name].[hash].js' : '[chunkhash].js'),
            chunk: ({ isDev }) =>
                isDev ? '[name].[hash].js' : '[chunkhash].js',
        },
        extend(config, ctx) {
            config.module.rules.push({
                test: /\.(ogg|mp3|wav|mpe?g)$/i,
                loader: 'file-loader',
                options: {
                    esModule: false,
                    name: '[path][name].[ext]',
                },
            })
        },
    },
    vue: {
        config: {
            productionTip: false,
            devtools: true,
        },
    },
    // loading: '~/components/ui/LoadingBar.vue',
}

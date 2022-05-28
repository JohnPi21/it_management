<template>
    <div id="page">
        <div class="container">
            <div class="blur"></div>
            <div
                class="fade col-10 col-sm-10 col-md-8 col-lg-8 col-xl-5 col-xxl-3"
            ></div>
            <div
                class="form col-8 col-sm-8 col-md-6 col-lg-6 col-xl-4 col-xxl-2"
            >
                <h1>Login</h1>
                <div class="g-btn"></div>

                <p>If you can't connect, contact support!</p>
                <!-- <button @click="loginUser()">Login</button> -->
                <img src="~/assets/images/auto_logo.png" alt="Logo Autototal" />
                <p>OR</p>
                <button class="g-btn" @click="guestLogin()">Guest Login</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({}),
    mounted() {
        let i = true
        this.$nextTick(() => {
            try {
                google.accounts.id.initialize({
                    client_id:
                        'GOOGLE_TOKEN_ID',
                    callback: this.handleCredentialResponse,
                })
                google.accounts.id.renderButton(
                    document.querySelector('.g-btn'),
                    { theme: 'dark', size: 'large' } // customization attributes
                )
            } catch (error) {}

            // google.accounts.id.prompt() // also display the One Tap dialog
        })
    },
    methods: {
        handleCredentialResponse(r) {
            const user = this.$axios
                .$post(
                    'auth/login',
                    {
                        google_token: r.credential,
                    },
                    { withCredentials: true }
                )
                .then((response) => {
                    this.$store.commit('set_auth', response)
                    window.$nuxt.$router.push('/')
                })
        },
        guestLogin() {
            const user = this.$axios
                .$post('auth/guest_login', { withCredentials: true })
                .then((response) => {
                    this.$store.commit('set_auth', response)
                    window.$nuxt.$router.push('/')
                })
        },
    },
}
</script>

<style lang="scss" scoped>
#page {
    width: 100vw;
    height: 100vh;
    margin: 0;
    z-index: 50;
    // background-image: url('~/assets/images/login-bk.jpg');
    // background-size: cover;
    overflow-y: hidden;
    overflow-x: hidden;
}
.container {
    display: flex;
    min-height: 100%;
    min-width: 100%;
    align-items: center;
    justify-content: center;

    .blur {
        position: absolute;
        min-height: 100%;
        min-width: 100%;
        background-image: url('~/assets/images/login-bk.jpg');
        background-size: cover;
        filter: blur(5px);
    }

    .fade {
        background-color: black;
        opacity: 0.93;
        height: 50vh;
        min-width: 200px;
        min-height: 400px;
        border-radius: 3px;
        box-shadow: 1px 1px 7px black;
    }
    .form {
        position: absolute;
        height: 50%;
        display: flex;
        flex-direction: column;
        text-align: center;

        h1 {
            font-size: 32px;
            margin: 50px 0px 30px 0px;
        }
        p {
            font-size: 21px;
        }
        .g-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px;
        }
        button {
            font-family: 'Roboto', sans-serif;
            margin-top: 10%;
            width: 100%;
            padding: 15px;
            line-height: 5px;
            font-size: 16px;
            background-color: #fa3a2b;
            color: white;
            border: 1px solid rgba(95, 34, 51, 0.30196);
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #f7655b;
            transition: 0.2s;
        }
        img {
            max-width: 100%;
            max-height: 100%;
            width: 45%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 40px;
        }
    }
}
</style>

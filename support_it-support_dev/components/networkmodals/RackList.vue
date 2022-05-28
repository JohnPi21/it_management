<template>
    <div class="modal-container">
        <SwitchPort
            v-if="modals.switch"
            @switch-port="$toggleModal('switch')"
        />
        <div class="modal-bk" @click="$emit('rack-list')"></div>
        <div class="container modal">
            <div v-for="sw in switchList" :key="sw.id" class="switch">
                <span @click="$toggleModal('switch')">{{ sw }}</span>
                <font-awesome-icon :icon="['fas', 'circle']" class="icon" />
            </div>
        </div>
    </div>
</template>

<script>
import SwitchPort from '~/components/networkmodals/SwitchPort.vue'

export default {
    components: {
        SwitchPort,
    },
    data: () => ({
        switchList: ['GS2200-8-01 *', 'GS2210-8-12', 'GS135018HP-01'],
        modals: {
            switch: false,
        },
    }),
    // async fetch() {
    //     const devices = ['telefon', 'sim', 'scaner', 'cuseta', 'depozit']
    //     for (let i = 0; i < devices.length; i++) {
    //         const element = await this.$axios.$get(
    //             'picking/vuex/' + devices[i]
    //         )
    //         this.$store.commit('set_picking', [devices[i], element])
    //     }
    // },

    computed: {},

    methods: {},
}
</script>

<style lang="scss" scoped>
.modal-bk {
    background-color: rgba(0, 0, 0, 0.35);
}
.modal {
    z-index: 200;
    min-width: 50%;
    width: auto;
    min-height: 10%;
    background-color: rgb(255, 255, 255);
    border: 1px solid rgba(0, 0, 0, 0.13);
}
.switch {
    display: flex;
    color: black;
    padding: 10px;
    justify-content: space-between;

    span {
        cursor: pointer;
        white-space: nowrap;
    }
    .icon {
        color: green;
    }
}
</style>

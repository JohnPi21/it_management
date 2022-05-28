<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('new-sim')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>New SIM</h3>
            <div class="grid-container">
                <div class="input-container">
                    <input
                        v-model="selectedData.nr_tel"
                        :inp="selectedData.nr_tel"
                        type="text"
                    />
                    <label>Numar Telefon</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.ip"
                        :inp="selectedData.ip"
                        type="text"
                    />
                    <label for="ip">IP</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.ssn"
                        :inp="selectedData.ssn"
                        type="text"
                    />
                    <label for="ssn">SSN</label>
                </div>

                <div class="input-container">
                    <input
                        v-model="selectedData.puk"
                        :inp="selectedData.puk"
                        type="text"
                    />
                    <label for="puk">PUK</label>
                </div>
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="selectedData.status"
                            readonly
                            :inp="selectedData.status"
                            type="text"
                            @click="$toggleModal('status')"
                        />
                        <label for="status">Status</label>
                    </div>
                    <div v-show="modals.status" class="list-container">
                        <input ref="status" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="stat in status"
                                :key="stat.id"
                                @click="$selectData(stat, 'status')"
                                >{{ stat }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <quill-editor
                ref="editor"
                v-model="selectedData.obs"
                class="ql-edit"
            />
            <div class="h-bar">
                <button class="g-button">Cancel</button>
                <button class="g-button" @click="postData()">Add SIM</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        status: ['INACTIV', 'STOC'],
        selectedData: {
            nr_tel: '',
            ip: '',
            ssn: '',
            puk: '',
            status: '',
            obs: '',
        },
        modals: {
            status: false,
        },
        actions: {
            filter: '',
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

    methods: {
        postData() {
            this.$axios
                .$post('picking/create/picking_sim', {
                    nr_tel: this.selectedData.nr_tel,
                    ip: this.selectedData.ip,
                    ssn: this.selectedData.ssn,
                    status: this.selectedData.status,
                    obs: this.selectedData.obs,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('new-sim'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

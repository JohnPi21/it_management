<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('edit-sim')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>Edit SIM</h3>
            <div class="grid-container">
                <div class="input-container">
                    <input :value="propData.nr_tel" readonly type="text" />
                    <label>Numar Telefon</label>
                </div>
                <div class="input-container">
                    <input :value="propData.ip" readonly type="text" />
                    <label for="ip">IP</label>
                    <span
                        class="delete"
                        @click="$deleteData('ip', 'picking_sim')"
                        ><font-awesome-icon icon="fa-solid fa-xmark"
                    /></span>
                </div>
                <div class="input-container">
                    <input :value="propData.ssn" readonly type="text" />
                    <label for="ssn">SSN</label>
                </div>

                <div class="input-container">
                    <input :value="propData.puk" readonly type="text" />
                    <label for="puk">PUK</label>
                    <span
                        class="delete"
                        @click="$deleteData('puk', 'picking_sim')"
                        ><font-awesome-icon icon="fa-solid fa-xmark"
                    /></span>
                </div>
                <div class="input-container">
                    <input readonly :value="propData.status" type="text" />
                    <label for="status">Status</label>
                </div>
            </div>

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
                            <!-- <span
                                v-for="telefon in $store.getters.filterAsset([
                                    'depozit',
                                    actions.filter,
                                ])"
                                :key="telefon.id"
                                @click="$selectData(telefon.tag, 'status')"
                                >{{ telefon.tag }}
                                <font-awesome-icon
                                    :icon="['fa', 'plus-circle']"
                                    class="icon"
                                />
                            </span> -->
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
                <button class="g-button" @click="$emit('edit-sim')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">Edit SIM</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        editData: {
            type: Object,
            required: true,
        },
    },

    data: () => ({
        status: ['INACTIV', 'STOC'],
        propData: {},
        selectedData: {
            nr_tel: '',
            ip: '',
            ssn: '',
            puk: '',
            status: '',
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
    mounted() {
        this.propData = this.editData
    },

    methods: {
        postData() {
            this.$axios
                .$post('picking/update/picking_sim', {
                    id: this.editData.id,
                    nr_tel: this.selectedData.nr_tel,
                    ip: this.selectedData.ip,
                    ssn: this.selectedData.ssn,
                    puk: this.selectedData.puk,
                    status: this.selectedData.status,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('edit-sim'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

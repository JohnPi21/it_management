<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('new-picking')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>New Picking</h3>
            <div class="grid-container">
                <!-- TELEFON  -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="newName.telefon"
                            readonly
                            :inp="newName.telefon"
                            type="text"
                            @click="$toggleModal('telefon')"
                        />
                        <label for="telefon">Telefon</label>
                    </div>
                    <div v-show="modals.telefon" class="list-container">
                        <input ref="telefon" v-model="actions.filter" />
                        <div class="el-container">
                            <span @click="$selectData('NECUNOSCUT', 'telefon')"
                                >Necunoscut</span
                            >
                            <span
                                v-for="telefon in $store.getters.filterAsset([
                                    'telefon',
                                    actions.filter,
                                ])"
                                :key="telefon.id"
                                @click="$selectData(telefon.id, 'telefon')"
                                >{{ telefon.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- SCANER -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="newName.scaner"
                            readonly
                            :inp="newName.scaner"
                            type="text"
                            @click="$toggleModal('scaner')"
                        />
                        <label for="scaner">Scaner</label>
                    </div>
                    <div v-show="modals.scaner" class="list-container">
                        <input ref="scaner" v-model="actions.filter" />
                        <div class="el-container">
                            <span @click="$selectData('NECUNOSCUT', 'scaner')"
                                >Necunoscut</span
                            >
                            <span
                                v-for="scaner in $store.getters.filterAsset([
                                    'scaner',
                                    actions.filter,
                                ])"
                                :key="scaner.id"
                                @click="$selectData(scaner.id, 'scaner')"
                                >{{ scaner.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- SIM -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="newName.sim"
                            readonly
                            :inp="newName.sim"
                            type="text"
                            @click="$toggleModal('sim')"
                        />
                        <label for="sim">SIM</label>
                    </div>
                    <div v-show="modals.sim" class="list-container">
                        <input ref="sim" v-model="actions.filter" />
                        <div class="el-container">
                            <span @click="$selectData('NECUNOSCUT', 'sim')"
                                >Necunoscut</span
                            >
                            <span
                                v-for="sim in $store.getters.filterAsset([
                                    'sim',
                                    actions.filter,
                                ])"
                                :key="sim.id"
                                @click="$selectData(sim.id, 'sim')"
                                >{{ sim.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- DEPOZIT -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="newName.depozit"
                            readonly
                            :inp="newName.depozit"
                            type="text"
                            @click="$toggleModal('depozit')"
                        />
                        <label for="depozit">Depozit</label>
                    </div>
                    <div v-show="modals.depozit" class="list-container">
                        <input ref="depozit" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="depozit in $store.getters.filterAsset([
                                    'depozit',
                                    actions.filter,
                                ])"
                                :key="depozit.id"
                                @click="$selectData(depozit.id, 'depozit')"
                                >{{ depozit.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- CUSETA -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="newName.cuseta"
                            readonly
                            :inp="newName.cuseta"
                            type="text"
                            @click="$toggleModal('cuseta')"
                        />
                        <label for="cuseta">Cuseta</label>
                    </div>
                    <div v-show="modals.cuseta" class="list-container">
                        <input ref="cuseta" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="cuseta in $store.getters.filterAsset([
                                    'cuseta',
                                    actions.filter,
                                ])"
                                :key="cuseta.id"
                                @click="$selectData(cuseta.id, 'cuseta')"
                                >{{ cuseta.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Telefon USER -->
                <div class="input-container">
                    <input
                        v-model="selectedData.tel_user"
                        :inp="selectedData.tel_user"
                        type="text"
                    />
                    <label for="tel_user">Telefon User</label>
                </div>
                <!-- USER -->
                <div class="input-container">
                    <input
                        v-model="selectedData.user"
                        :inp="selectedData.user"
                        type="text"
                    />
                    <label for="user">User</label>
                </div>
            </div>

            <quill-editor
                ref="editor"
                v-model="selectedData.obs"
                class="ql-edit"
            />
            <div class="h-bar">
                <button class="g-button" @click="$emit('new-picking')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Add Picking
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        selectedData: {
            telefon: '',
            scaner: '',
            sim: '',
            depozit: '',
            cuseta: '',
            user: '',
            tel_user: '',
            obs: '',
        },
        modals: {
            telefon: false,
            scaner: false,
            sim: false,
            depozit: false,
            cuseta: false,
        },
        actions: {
            filter: '',
        },
        newName: {
            telefon: '',
            scaner: '',
            sim: '',
            depozit: '',
            cuseta: '',
        },
    }),
    async fetch() {
        const devices = ['telefon', 'sim', 'scaner', 'cuseta', 'depozit']
        for (let i = 0; i < devices.length; i++) {
            const element = await this.$axios.$get('picking/vuex/' + devices[i])
            this.$store.commit('set_picking', [devices[i], element])
        }
    },

    methods: {
        postData() {
            this.$axios
                .$post('picking/create/picking', {
                    id_telefon: this.selectedData.telefon,
                    id_scaner: this.selectedData.scaner,
                    id_sim: this.selectedData.sim,
                    id_depozit: this.selectedData.depozit,
                    id_cuseta: this.selectedData.cuseta,
                    user: this.selectedData.user,
                    tel_user: this.selectedData.tel_user,
                    obs: this.selectedData.obs,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('new-picking'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

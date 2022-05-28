<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('new-inventar')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>New Inventar</h3>
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
            <div class="container date-picker">
                <div class="calendar-container">
                    <label>Data Trimis</label>
                    <vc-date-picker
                        v-model="selectedData.data_trimis"
                        :model-config="modelConfig"
                    />
                </div>
                <div class="calendar-container">
                    <label>Data Primit</label>
                    <vc-date-picker
                        v-model="selectedData.data_primit"
                        :model-config="modelConfig"
                    />
                </div>
            </div>
            <quill-editor
                ref="editor"
                v-model="selectedData.obs"
                class="ql-edit"
            />
            <div class="h-bar">
                <button class="g-button" @click="$emit('new-inventar')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Add inventar
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
            user: '',
            obs: '',
        },
        modals: {
            telefon: false,
            scaner: false,
            sim: false,
            depozit: false,
        },
        actions: {
            filter: '',
        },
        modelConfig: {
            type: 'string',
            mask: 'YYYY-MM-DD hh:mm:ss', // Uses 'iso' if missing
        },
        newName: {
            telefon: '',
            scaner: '',
            sim: '',
            depozit: '',
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
                .$post('picking/create/picking_inventar', {
                    id_telefon: this.selectedData.telefon,
                    id_scaner: this.selectedData.scaner,
                    id_sim: this.selectedData.sim,
                    id_depozit: this.selectedData.depozit,
                    user: this.selectedData.user,
                    obs: this.selectedData.obs,
                    data_trimis: this.selectedData.data_trimis,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('new-inventar'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

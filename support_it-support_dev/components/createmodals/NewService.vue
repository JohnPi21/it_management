<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('new-service')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>New Service</h3>
            <div class="grid-container">
                <!-- ############# SERVICE ############# -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="selectedData.service"
                            readonly
                            :inp="selectedData.service"
                            type="text"
                            @click="$toggleModal('service')"
                        />
                        <label for="service">Service</label>
                    </div>
                    <div v-show="modals.service" class="list-container">
                        <input ref="service" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="serv in selectors.services"
                                :key="serv"
                                @click="$selectData(serv, 'service')"
                                >{{ serv }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############# TYPE ############# -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="selectedData.type"
                            readonly
                            :inp="selectedData.type"
                            type="text"
                            @click="$toggleModal('type')"
                        />
                        <label for="type">Tip Device</label>
                    </div>
                    <div v-show="modals.type" class="list-container">
                        <input ref="type" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="type in selectors.type"
                                :key="type"
                                @click="$selectData(type, 'type')"
                                >{{ type }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############# TELEFON ############# -->
                <div
                    v-show="selectedData.type == 'TELEFON'"
                    class="input-list-container"
                >
                    <div class="input-container">
                        <input
                            v-model="newName.telefon"
                            readonly
                            :inp="newName.telefon"
                            type="text"
                            @click="$toggleModal('telefon')"
                        />
                        <label for="device">Telefon</label>
                    </div>
                    <div v-show="modals.telefon" class="list-container">
                        <input ref="telefon" v-model="actions.filter" />
                        <div class="el-container">
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
                <!-- ############# SCANER ############# -->
                <div
                    v-show="selectedData.type == 'SCANER'"
                    class="input-list-container"
                >
                    <div class="input-container">
                        <input
                            v-model="newName.scaner"
                            readonly
                            :inp="newName.scaner"
                            type="text"
                            @click="$toggleModal('scaner')"
                        />
                        <label for="device">Scaner</label>
                    </div>
                    <div v-show="modals.scaner" class="list-container">
                        <input ref="scaner" v-model="actions.filter" />
                        <div class="el-container">
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
                <!-- ############# DEPOZIT ############# -->
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
                <!-- ############# STATUS ############# -->
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
                                v-for="status in selectors.status"
                                :key="status"
                                @click="$selectData(status, 'status')"
                                >{{ status }}
                            </span>
                        </div>
                    </div>
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
                <button class="g-button" @click="$emit('new-service')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Add Service
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        selectors: {
            services: ['TOTAL ZONE', 'ORANGE', 'DEPANERO'],
            status: ['SERVICE'],
            type: ['TELEFON', 'SCANER'],
        },
        selectedData: {
            depozit: '',
            type: '',
            device: '',
            telefon: false,
            scaner: false,
            obs: '',
            service: 'TOTAL ZONE',
            status: 'SERVICE',
            data_trimis: '',
            data_primit: '',
        },
        modals: {
            telefon: false,
            scaner: false,
            type: false,
            depozit: false,
            service: false,
            status: false,
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
            depozit: '',
        },
    }),
    async fetch() {
        const devices = ['telefon', 'scaner', 'depozit']
        for (let i = 0; i < devices.length; i++) {
            const element = await this.$axios.$get('picking/vuex/' + devices[i])
            this.$store.commit('set_picking', [devices[i], element])
        }
    },

    methods: {
        postData() {
            this.$axios
                .$post('picking/create/picking_service', {
                    id_depozit: this.selectedData.depozit,
                    service: this.selectedData.service,
                    id_device: this.selectedData.telefon
                        ? this.selectedData.telefon
                        : this.selectedData.scaner,
                    data_trimis: this.selectedData.data_trimis,
                    data_primit: this.selectedData.data_primit,
                    status: this.selectedData.status,
                    obs: this.selectedData.obs,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('new-service'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

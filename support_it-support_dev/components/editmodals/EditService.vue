<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('edit-service')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>Edit Service</h3>
            <!-- <div class="grid-container"></div> E containerul randurilor de input 1 display <=>1 edit -->

            <!--################ simple current data container ################-->
            <!-- <div class="input-container">
                    <input :value="propData.telefon" readonly type="text" />
                    <label>Telefon</label>
                </div> -->

            <!--################  Current data container with delete function  ############## -->
            <!-- <div class="input-container">
                    <input :value="propData.ip" readonly type="text" />
                    <label for="ip">IP</label>
                    <span class="delete" @click="$deleteData('ip', 'picking')"
                        ><font-awesome-icon icon="fa-solid fa-xmark"
                    /></span>
                </div> -->
            <!-- ############### DROPDOWN LIST INPUT SELECT ############# -->
            <!-- <div class="input-list-container">
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
                            </span>
                        </div>
                    </div>
                </div> -->
            <!-- ################ SIMPLE INPUT DATA ############### -->
            <!-- <div class="input-container">
                    <input
                        v-model="selectedData.puk"
                        :inp="selectedData.puk"
                        type="text"
                    />
                    <label for="puk">PUK</label>
                </div> -->
            <div class="grid-container">
                <div class="input-container">
                    <input :value="propData.tag" readonly type="text" />
                    <label>Tag</label>
                </div>
                <div class="input-container">
                    <input :value="propData.depozit" readonly type="text" />
                    <label>Depozit</label>
                </div>
                <div v-if="propData.sn" class="input-container">
                    <input :value="propData.sn" readonly type="text" />
                    <label>SN</label>
                </div>
                <div v-if="propData.imei" class="input-container">
                    <input :value="propData.imei" readonly type="text" />
                    <label>IMEI</label>
                </div>
                <div class="input-container">
                    <input :value="propData.status" readonly type="text" />
                    <label>Status</label>
                </div>
            </div>
            <div class="grid-container">
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
                                v-for="serv in service"
                                :key="serv.id"
                                @click="$selectData(serv, 'service')"
                            >
                                {{ serv }}
                            </span>
                        </div>
                    </div>
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
                            >
                                {{ stat }}
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
            <div class="quill-container">
                <span
                    class="delete icon"
                    @click="$deleteData('obs', 'picking_service')"
                    ><font-awesome-icon icon="fa-solid fa-xmark"
                /></span>
                <quill-editor
                    ref="editor"
                    v-model="selectedData.obs"
                    class="ql-edit"
                />
            </div>
            <div class="h-bar">
                <button class="g-button" @click="$emit('edit-service')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Edit Service
                </button>
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
        status: ['REPARAT', 'SERVICE', 'CASAT'],
        service: ['TOTAL ZONE', 'ORANGE', 'DEPANERO'],
        propData: {},
        selectedData: {
            service: 'TOTAL ZONE',
            status: 'SERVICE',
            data_trimis: '',
            data_primit: '',
            obs: '',
        },
        modals: {
            status: '',
            service: '',
        },
        modelConfig: {
            type: 'string',
            mask: 'YYYY-MM-DD hh:mm:ss', // Uses 'iso' if missing
        },
        actions: {
            filter: '',
        },
    }),

    mounted() {
        this.propData = this.editData
        this.selectedData.obs = this.propData.obs
    },

    methods: {
        postData() {
            this.$axios
                .$post('picking/update/picking_service', {
                    id: this.editData.id,
                    status: this.selectedData.status,
                    service: this.selectedData.service,
                    obs: this.selectedData.obs,
                    data_trimis: this.selectedData.data_trimis,
                    data_primit: this.selectedData.data_primit,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('edit-service'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('edit-telefon')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>Edit Telefon</h3>
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
                    <input :value="propData.marca" readonly type="text" />
                    <label for="marca">Marca</label>
                    <span
                        class="delete"
                        @click="$deleteData('marca', 'picking_devices')"
                        ><font-awesome-icon icon="fa-solid fa-xmark"
                    /></span>
                </div>
                <div class="input-container">
                    <input :value="propData.model" readonly type="text" />
                    <label for="model">Model</label>
                    <span
                        class="delete"
                        @click="$deleteData('model', 'picking_devices')"
                        ><font-awesome-icon icon="fa-solid fa-xmark"
                    /></span>
                </div>
                <div class="input-container">
                    <input :value="propData.sn" readonly type="text" />
                    <label>SN</label>
                </div>
                <div class="input-container">
                    <input :value="propData.imei" readonly type="text" />
                    <label>IMEI</label>
                </div>
                <div class="input-container">
                    <input :value="propData.imei2" readonly type="text" />
                    <label>IMEI 2</label>
                </div>
                <div class="input-container">
                    <input :value="propData.mac" readonly type="text" />
                    <label for="mac">MAC</label>
                    <span
                        class="delete"
                        @click="$deleteData('mac', 'picking_devices')"
                        ><font-awesome-icon icon="fa-solid fa-xmark"
                    /></span>
                </div>
                <div class="input-container">
                    <input :value="propData.status" readonly type="text" />
                    <label>Status</label>
                </div>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <input
                        v-model="selectedData.tag"
                        :inp="selectedData.tag"
                        type="text"
                    />
                    <label for="puk">Tag</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.marca"
                        :inp="selectedData.marca"
                        type="text"
                    />
                    <label for="marca">Marca</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.model"
                        :inp="selectedData.model"
                        type="text"
                    />
                    <label for="model">Model</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.sn"
                        :inp="selectedData.sn"
                        type="text"
                    />
                    <label for="sn">SN</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.imei"
                        :inp="selectedData.imei"
                        type="text"
                    />
                    <label for="imei">IMEI</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.imei2"
                        :inp="selectedData.imei2"
                        type="text"
                    />
                    <label for="imei2">IMEI2</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.mac"
                        :inp="selectedData.mac"
                        type="text"
                    />
                    <label for="mac">MAC</label>
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
            <div class="quill-container">
                <span
                    class="delete icon"
                    @click="$deleteData('obs', 'picking_devices')"
                    ><font-awesome-icon icon="fa-solid fa-xmark"
                /></span>
                <quill-editor
                    ref="editor"
                    v-model="selectedData.obs"
                    class="ql-edit"
                />
            </div>
            <div class="h-bar">
                <button class="g-button" @click="$emit('edit-telefon')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Edit Telefon
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
        status: [
            'STOC',
            'SERVICE',
            'CASAT',
            'UZ',
            'INVENTAR',
            'NECUNOSCUT',
            'LIPSA',
        ],
        propData: {},
        selectedData: {
            tag: '',
            marca: '',
            model: '',
            sn: '',
            imei: '',
            imei2: '',
            mac: '',
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
    mounted() {
        this.propData = this.editData
        this.selectedData.obs = this.propData.obs
    },

    methods: {
        postData() {
            this.$axios
                .$post('picking/update/picking_telefon', {
                    id: this.editData.id,
                    tag: this.selectedData.tag,
                    marca: this.selectedData.marca,
                    model: this.selectedData.model,
                    sn: this.selectedData.sn,
                    imei: this.selectedData.imei,
                    imei2: this.selectedData.imei2,
                    mac: this.selectedData.mac,
                    status: this.selectedData.status,
                    obs: this.selectedData.obs,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('edit-telefon'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

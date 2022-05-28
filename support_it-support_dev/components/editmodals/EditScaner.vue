<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('edit-scaner')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>Edit Scaner</h3>
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
                                >{{ stat }}</span
                            >
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
                <button class="g-button" @click="$emit('edit-scaner')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Edit Scaner
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
                .$post('picking/update/picking_scaner', {
                    id: this.editData.id,
                    tag: this.selectedData.tag,
                    marca: this.selectedData.marca,
                    model: this.selectedData.model,
                    sn: this.selectedData.sn,
                    mac: this.selectedData.mac,
                    status: this.selectedData.status,
                    obs: this.selectedData.obs,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('edit-scaner'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

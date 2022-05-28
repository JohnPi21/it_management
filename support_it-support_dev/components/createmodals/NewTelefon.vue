<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('new-telefon')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>New Telefon</h3>
            <div class="grid-container">
                <div class="input-container">
                    <input
                        v-model="selectedData.tag"
                        :inp="selectedData.tag"
                        type="text"
                    />
                    <label>Tag</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.marca"
                        :inp="selectedData.marca"
                        type="text"
                    />
                    <label>Marca</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.model"
                        :inp="selectedData.model"
                        type="text"
                    />
                    <label>Model</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.sn"
                        :inp="selectedData.sn"
                        type="text"
                    />
                    <label>SN</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.imei"
                        :inp="selectedData.imei"
                        type="text"
                    />
                    <label>IMEI</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.imei2"
                        :inp="selectedData.imei2"
                        type="text"
                    />
                    <label>IMEI2</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.mac"
                        :inp="selectedData.mac"
                        type="text"
                    />
                    <label>MAC</label>
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
                <button class="g-button" @click="$emit('new-telefon')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Add Telefon
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        status: ['STOC', 'CASAT', 'NECUNOSCUT', 'LIPSA'],
        selectedData: {
            tag: '',
            marca: '',
            model: '',
            sn: '',
            imei: '',
            imei2: '',
            mac: '',
            status: '',
        },
        modals: {
            status: false,
        },
        actions: {
            filter: '',
        },
    }),
    computed: {},

    methods: {
        postData() {
            this.$axios
                .$post('picking/create/picking_telefon', {
                    tag: this.selectedData.tag,
                    marca: this.selectedData.marca,
                    model: this.selectedData.model,
                    sn: this.selectedData.sn,
                    imei: this.selectedData.imei,
                    imei2: this.selectedData.imei2,
                    mac: this.selectedData.mac,
                    status: this.selectedData.status,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('new-telefon'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

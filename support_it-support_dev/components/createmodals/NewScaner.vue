<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('new-scaner')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>New Scaner</h3>
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
                <button class="g-button" @click="$emit('new-scaner')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">Add Scaner</button>
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
                .$post('picking/create/picking_scaner', {
                    tag: this.selectedData.tag,
                    marca: this.selectedData.marca,
                    model: this.selectedData.model,
                    sn: this.selectedData.sn,
                    mac: this.selectedData.mac,
                    status: this.selectedData.status,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('new-scaner'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('edit-device')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>Edit Device</h3>
            <div class="grid-container">
                <div class="input-container">
                    <input :value="propData.tag" readonly type="text" />
                    <label>Tag</label>
                </div>
                <div class="input-container">
                    <input :value="propData.locatie" readonly type="text" />
                    <label>Locatie</label>
                </div>
                <div class="input-container">
                    <input :value="propData.user" readonly type="text" />
                    <label>User</label>
                </div>
                <div class="input-container">
                    <input :value="propData.os" readonly type="text" />
                    <label>OS</label>
                </div>
                <div class="input-container">
                    <input :value="propData.ram" readonly type="text" />
                    <label>RAM</label>
                </div>
                <div class="input-container">
                    <input :value="propData.cpu" readonly type="text" />
                    <label>CPU</label>
                </div>
                <div class="input-container">
                    <input :value="propData.mac" readonly type="text" />
                    <label>MAC</label>
                </div>
                <div class="input-container">
                    <input :value="propData.model" readonly type="text" />
                    <label>Model</label>
                </div>
                <div class="input-container">
                    <input :value="propData.sn" readonly type="text" />
                    <label>SN</label>
                </div>
                <div class="input-container">
                    <input
                        :value="propData.numar_porturi"
                        readonly
                        type="text"
                    />
                    <label>Numar Porturi</label>
                </div>
                <div class="input-container">
                    <input :value="propData.rack" readonly type="text" />
                    <label>Rack</label>
                </div>
                <div class="input-container">
                    <input :value="propData.link" readonly type="text" />
                    <label>Link</label>
                </div>
            </div>
            <div class="grid-container">
                <!-- ################ Device tag ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.tag"
                        :inp="selectedData.tag"
                        type="text"
                    />
                    <label for="tag">Tag</label>
                </div>
                <!-- ################ Device type ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.type"
                        :inp="selectedData.type"
                        type="text"
                    />
                    <label for="type">Type</label>
                </div>
                <!-- ################ Device Locatie ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.locatie"
                        :inp="selectedData.locatie"
                        type="text"
                    />
                    <label for="locatie">Locatie</label>
                </div>
                <!-- ################ Device User ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.user"
                        :inp="selectedData.user"
                        type="text"
                    />
                    <label for="user">User</label>
                </div>
                <!-- ################ Device OS ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.os"
                        :inp="selectedData.os"
                        type="text"
                    />
                    <label for="os">OS</label>
                </div>
                <!-- ################ Device RAM ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.ram"
                        :inp="selectedData.ram"
                        type="number"
                    />
                    <label for="ram">RAM</label>
                </div>
                <!-- ################ Device CPU ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.cpu"
                        :inp="selectedData.cpu"
                        type="text"
                    />
                    <label for="cpu">CPU</label>
                </div>
                <!-- ################ Device MODEL ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.model"
                        :inp="selectedData.model"
                        type="text"
                    />
                    <label for="model">Model</label>
                </div>
                <!-- ################ Device SN ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.sn"
                        :inp="selectedData.sn"
                        type="text"
                    />
                    <label for="sn">SN</label>
                </div>
                <!-- ################ Numar porturi device ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.numar_porturi"
                        :inp="selectedData.numar_porturi"
                        type="number"
                    />
                    <label for="numar_porturi">Numar Porturi</label>
                </div>
                <!-- ################ Device Rack ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.rack"
                        :inp="selectedData.rack"
                        type="text"
                    />
                    <label for="rack">Rack</label>
                </div>
                <!-- ################ Device link_fisa ############### -->
                <div class="input-container">
                    <input
                        v-model="selectedData.link_fisa"
                        :inp="selectedData.link_fisa"
                        type="text"
                    />
                    <label for="link_fisa">Link Fisa</label>
                </div>
            </div>
            <div class="quill-container">
                <span class="delete icon" @click="$deleteData('fisa', 'device')"
                    ><font-awesome-icon icon="fa-solid fa-xmark"
                /></span>
                <quill-editor
                    ref="editor"
                    v-model="selectedData.fisa"
                    class="ql-edit"
                />
            </div>
            <div class="h-bar">
                <button class="g-button" @click="$emit('edit-device')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Edit Device
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
        modals: {},
        propData: {},
        selectedData: {
            type: '',
            tag: '',
            locatie: '',
            user: '',
            os: '',
            ram: '',
            cpu: '',
            model: '',
            sn: '',
            numar_porturi: '',
            rack: '',
            link_fisa: '',
            fisa: '',
            status: '',
        },
    }),

    mounted() {
        this.propData = this.editData
        this.selectedData.fisa = this.propData.fisa
    },

    methods: {
        postData() {
            this.$axios
                .$post('devices/update/device', {
                    id: this.editData.id,
                    type: this.selectedData.type,
                    tag: this.selectedData.tag,
                    locatie: this.selectedData.locatie,
                    user: this.selectedData.user,
                    os: this.selectedData.os,
                    ram: this.selectedData.ram,
                    cpu: this.selectedData.cpu,
                    model: this.selectedData.model,
                    sn: this.selectedData.sn,
                    numar_porturi: this.selectedData.numar_porturi,
                    rack: this.selectedData.rack,
                    link_fisa: this.selectedData.link_fisa,
                    fisa: this.selectedData.fisa,
                    status: this.selectedData.status,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('edit-device'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

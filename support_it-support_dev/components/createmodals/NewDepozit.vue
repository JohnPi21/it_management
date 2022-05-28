<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('new-depozit')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>New Depozit</h3>
            <div class="grid-container">
                <div class="input-container">
                    <input
                        v-model="selectedData.nume"
                        :inp="selectedData.nume"
                        type="text"
                    />
                    <label>Nume</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.tip"
                        :inp="selectedData.tip"
                        type="text"
                    />
                    <label>Tip</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.indicativ"
                        :inp="selectedData.indicativ"
                        type="text"
                    />
                    <label>Indicativ</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.adresa"
                        :inp="selectedData.adresa"
                        type="text"
                    />
                    <label>Adresa</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.mail_depozit"
                        :inp="selectedData.mail_depozit"
                        type="text"
                    />
                    <label>Email depozit</label>
                </div>
            </div>
            <div class="grid-container">
                <div class="input-container">
                    <input
                        v-model="selectedData.telefon_depozit"
                        :inp="selectedData.telefon_depozit"
                        type="text"
                    />
                    <label>Telefon depozit</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.sef_depozit"
                        :inp="selectedData.sef_depozit"
                        type="text"
                    />
                    <label>Sef depozit</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.mail_sef"
                        :inp="selectedData.mail_sef"
                        type="text"
                    />
                    <label>Email sef</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.telefon_sef"
                        :inp="selectedData.telefon_sef"
                        type="text"
                    />
                    <label>Telefon sef</label>
                </div>
            </div>

            <quill-editor
                ref="editor"
                v-model="selectedData.obs"
                class="ql-edit"
            />
            <div class="h-bar">
                <button class="g-button" @click="$emit('new-depozit')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Add Depozit
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        selectedData: {
            nume: '',
            tip: '',
            indicativ: '',
            adresa: '',
            mail_depozit: '',
            telefon_depozit: '',
            sef_depozit: '',
            mail_sef: '',
            telefon_sef: '',
        },
        modals: {
            status: false,
        },
        actions: {
            filter: '',
        },
    }),
    methods: {
        postData() {
            this.$axios
                .$post('picking/create/depozit', {
                    nume: this.selectedData.nume,
                    tip: this.selectedData.tip,
                    indicativ: this.selectedData.indicativ,
                    adresa: this.selectedData.adresa,
                    mail_depozit: this.selectedData.mail_depozit,
                    telefon_depozit: this.selectedData.telefon_depozit,
                    sef_depozit: this.selectedData.sef_depozit,
                    mail_sef: this.selectedData.mail_sef,
                    telefon_sef: this.selectedData.telefon_sef,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('new-depozit'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

import Vue from 'vue'
Vue.prototype.$notification = notification
Vue.prototype.$toggleModal = toggleModal
Vue.prototype.$selectData = selectData
Vue.prototype.$closeModals = closeModals
Vue.prototype.$deleteData = deleteData
Vue.prototype.$deleteRow = deleteRow
Vue.prototype.$getName = getName
Vue.prototype.$check = check

function notification(response) {
    this.$store.commit('set_ui', ['info', response])
    setTimeout(() => {
        this.$store.commit('set_ui', ['info', []])
    }, 4000)
    this.$nuxt.refresh()
}

function toggleModal(name, info = null) {
    if (info != null) {
        this.props.edit = info
    }
    this.modals[name] = !this.modals[name]

    if (this.$refs[name]) {
        this.$nextTick(() => this.$refs[name].focus())
    }
    this.$nuxt.refresh()
}

function selectData(data, asset) {
    this.selectedData[asset] = data
    //DEVICE NECUNOSCUT
    if (data == 'NECUNOSCUT') {
        this.newName[asset] = 'Necunoscut'
        this.actions.filter = ''
        return
    }
    //Check if selected is number or string (statusul se trimite ca string)
    if (!isNaN(data)) {
        this.$getName(data, asset)
    }

    this.$toggleModal(asset)
    //Clear input filter
    if (this.actions.filter) {
        this.actions.filter = ''
    }
}

function getName(data, asset) {
    const name = this.$store.state.picking[asset].filter(
        (asset) => asset.id == data
    )
    this.newName[asset] = name[0].tag
}

function closeModals(event) {
    for (const [key] of Object.entries(this.modals)) {
        if (event.target.type != 'text') {
            this.modals[key] = false
        }
    }
}

function deleteData(data, table) {
    this.$axios
        .$post('picking/delete/' + table + '_data', {
            id: this.propData.id,
            column: data,
        })
        .then((response) => {
            this.$notification(response)
        })
        .then((this.propData[data] = ''))
        .then((this.selectedData[data] = ''))
}
function deleteRow(data, table) {
    if (confirm('Esti sigur ca vrei sa stergi?')) {
        this.$axios
            .$post('picking/delete/' + table, {
                id: data,
            })
            .then((response) => {
                this.$notification(response)
            })
    }
}
function check(table, id) {
    this.$axios
        .$post('picking/update/check', {
            id: id,
            table: table,
        })
        .then((response) => {
            this.$notification(response)
        })
}

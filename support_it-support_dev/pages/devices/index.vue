<template>
    <div id="page" class="container-fluid">
        <NewDevice
            v-if="modals.newDevice"
            @new-device="$toggleModal('newDevice')"
        />
        <EditDevice
            v-if="modals.editDevice"
            :edit-data="props.edit"
            @edit-device="$toggleModal('editDevice')"
        />
        <div class="page-title">
            <h1>Devices</h1>
            <button class="g-button" @click="$toggleModal('newDevice')">
                Add Device
            </button>
        </div>
        <div class="h-bar">
            <button class="g-button" @click="$copyToClipboard('main-t')">
                Copy
            </button>
            <button
                class="g-button"
                @click="$exportTableToCSV('Tabel_Device.csv')"
            >
                CSV
            </button>
            <button class="g-button" @click="$printData('Device')">
                Print
            </button>
            <div class="col-list-container">
                <button
                    class="g-button"
                    @click="modals.columnFilter = !modals.columnFilter"
                >
                    Column Visibility
                </button>
                <div v-if="modals.columnFilter" class="column-toggle">
                    <span
                        v-for="head in headers"
                        :key="head.id"
                        @click="$showColumns(head.name)"
                        >{{ head.display }}</span
                    >
                    <span @click="actions.actions = !actions.actions"
                        >Actions</span
                    >
                </div>
            </div>

            <button class="g-button">
                Filter Count: {{ filteredRows.length }}
            </button>

            <input
                v-model="actions.filter"
                class="g-input"
                type="text"
                placeholder="Search Item"
            />
        </div>

        <table id="main-t" ref="printTable" class="main-table">
            <!--################ TABLE HEAD ################# -->
            <thead>
                <tr>
                    <th
                        v-for="head in activeHeaders"
                        :key="head.id"
                        @click="
                            $sortItems(
                                head.name,
                                rows,
                                actions.sortOrder,
                                actions.currentSort
                            )
                        "
                    >
                        {{ head.display }}
                    </th>
                    <th v-if="actions.actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!--################ TABLE BODY ################# -->
                <tr v-for="row in limitRows" :key="row.id">
                    <td v-for="head in activeHeaders" :key="head.id">
                        <span v-if="head.name != 'obs'">{{
                            row[head.name]
                        }}</span>
                        <span
                            v-if="head.name == 'obs'"
                            v-html="row[head.name]"
                        ></span>
                    </td>
                    <td v-if="actions.actions">
                        <span
                            class="icon"
                            @click="$toggleModal('editDevice', row)"
                            ><font-awesome-icon
                                icon="fa-solid fa-pen-to-square"
                        /></span>
                        <span
                            class="icon"
                            @click="$deleteRow(row.id, 'devices')"
                            ><font-awesome-icon icon="fa-solid fa-trash-can"
                        /></span>
                        <span
                            class="icon"
                            @click="$check('device', row.id)"
                            :class="{ check: row.checked }"
                            ><font-awesome-icon icon="fa-solid fa-circle-check"
                        /></span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="h-bar">
            <button class="g-button" @click="$fullSize()">Show All</button>
        </div>
    </div>
</template>

<script>
import NewDevice from '~/components/createmodals/NewDevice.vue'
import EditDevice from '~/components/editmodals/EditDevice.vue'

export default {
    components: {
        NewDevice,
        EditDevice,
    },
    async asyncData({ $axios }) {
        const rows = await $axios
            .$get('network/read/devices')
            .then((response) => {
                if (!response || response.length === 0) {
                    throw {
                        statusCode: 404,
                        message: 'Server problem!',
                    }
                }
                return response
            })
        return { rows }
    },

    data: () => ({
        modals: {
            newDevice: false,
            editDevice: false,
            columnFilter: false,
        },
        headers: [
            { name: 'id', status: true, display: 'ID' },
            { name: 'type', status: true, display: 'Type' },
            { name: 'id_locatie', status: true, display: 'Locatie' },
            { name: 'tag', status: true, display: 'Tag' },
            { name: 'user', status: true, display: 'User' },
            { name: 'os', status: true, display: 'OS' },
            { name: 'ram', status: true, display: 'RAM' },
            { name: 'cpu', status: true, display: 'CPU' },
            { name: 'mac', status: true, display: 'MAC' },
            { name: 'model', status: true, display: 'Model' },
            { name: 'numar_porturi', status: false, display: 'Numar Porturi' },
            { name: 'id_rack', status: false, display: 'Rack' },
            { name: 'link_fisa', status: false, display: 'Fisa' },
            { name: 'fisa', status: false, display: 'Fisa' },
            { name: 'sn', status: true, display: 'SN' },
            { name: 'status', status: true, display: 'Status' },
        ],
        actions: {
            sortOrder: 'asc',
            currentSort: 'id',
            filter: '',
            actions: true,
            rowSize: 19,
        },
        props: {
            edit: [],
        },
    }),
    computed: {
        filteredRows() {
            return this.rows.filter((row) => {
                const id = String(row.id).toLowerCase()
                const type = String(row.type).toLowerCase()
                const id_locatie = String(row.id_locatie).toLowerCase()
                const tag = String(row.tag).toLowerCase()
                const user = String(row.user).toLowerCase()
                const os = String(row.os).toLowerCase()
                const ram = String(row.ram).toLowerCase()
                const cpu = String(row.cpu).toLowerCase()
                const mac = String(row.mac).toLowerCase()
                const model = String(row.model).toLowerCase()
                const numar_porturi = String(row.numar_porturi).toLowerCase()
                const id_rack = String(row.id_rack).toLowerCase()
                const link_fisa = String(row.link_fisa).toLowerCase()
                const fisa = String(row.fisa).toLowerCase()
                const sn = String(row.sn).toLowerCase()
                const status = String(row.status).toLowerCase()
                const filter = this.actions.filter.toLowerCase()

                return (
                    id.includes(filter) ||
                    type.includes(filter) ||
                    id_locatie.includes(filter) ||
                    tag.includes(filter) ||
                    user.includes(filter) ||
                    os.includes(filter) ||
                    ram.includes(filter) ||
                    cpu.includes(filter) ||
                    mac.includes(filter) ||
                    model.includes(filter) ||
                    numar_porturi.includes(filter) ||
                    id_rack.includes(filter) ||
                    link_fisa.includes(filter) ||
                    sn.includes(filter) ||
                    fisa.includes(filter) ||
                    status.includes(filter)
                )
            })
        },
        activeHeaders() {
            return this.headers.filter((head) => {
                return head.status == true
            })
        },
        limitRows() {
            return this.filteredRows.slice(0, this.actions.rowSize)
        },
    },

    methods: {},
}
</script>

<style lang="scss"></style>

<template>
    <!-- NEW PICKING, POPUP, EDIT PICKING  -->
    <div id="page" class="container-fluid">
        <NewTelefon
            v-if="modals.newTelefon"
            @new-telefon="$toggleModal('newTelefon')"
        />
        <EditTelefon
            v-if="modals.editTelefon"
            :edit-data="props.edit"
            @edit-telefon="$toggleModal('editTelefon')"
        />
        <div class="page-title">
            <h1>Telefoane</h1>
            <button class="g-button" @click="$toggleModal('newTelefon')">
                Add Telefon
            </button>
        </div>
        <div class="h-bar">
            <button class="g-button" @click="$copyToClipboard('main-t')">
                Copy
            </button>
            <button
                class="g-button"
                @click="$exportTableToCSV('Tabel_Telefon.csv')"
            >
                CSV
            </button>
            <button class="g-button" @click="$printData('Telefon')">
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
                            @click="$toggleModal('editTelefon', row)"
                            ><font-awesome-icon
                                icon="fa-solid fa-pen-to-square"
                        /></span>
                        <span
                            class="icon"
                            @click="$deleteRow(row.id, 'picking_telefon')"
                            ><font-awesome-icon icon="fa-solid fa-trash-can"
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
import NewTelefon from '~/components/createmodals/NewTelefon.vue'
import EditTelefon from '~/components/editmodals/EditTelefon.vue'

export default {
    components: {
        NewTelefon,
        EditTelefon,
    },
    async asyncData({ $axios }) {
        const response = await $axios.$get('picking/read/picking_telefon')
        const rows = response

        return { rows }
    },

    data: () => ({
        modals: {
            newTelefon: false,
            editTelefon: false,
            columnFilter: false,
        },
        headers: [
            { name: 'id', status: true, display: 'ID' },
            { name: 'tag', status: true, display: 'tag' },
            { name: 'marca', status: true, display: 'Marca' },
            { name: 'model', status: true, display: 'Model' },
            { name: 'sn', status: true, display: 'SN' },
            { name: 'imei', status: true, display: 'IMEI' },
            { name: 'imei2', status: true, display: 'IMEI2' },
            { name: 'mac', status: true, display: 'MAC' },
            { name: 'status', status: true, display: 'Status' },
            { name: 'obs', status: true, display: 'Obs' },
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
                const tag = String(row.tag).toLowerCase()
                const marca = String(row.marca).toLowerCase()
                const model = String(row.model).toLowerCase()
                const sn = String(row.sn).toLowerCase()
                const imei = String(row.imei).toLowerCase()
                const imei2 = String(row.imei2).toLowerCase()
                const mac = String(row.mac).toLowerCase()
                const status = String(row.status).toLowerCase()
                const obs = String(row.obs).toLowerCase()
                const filter = this.actions.filter.toLowerCase()

                return (
                    id.includes(filter) ||
                    tag.includes(filter) ||
                    marca.includes(filter) ||
                    model.includes(filter) ||
                    sn.includes(filter) ||
                    imei.includes(filter) ||
                    imei2.includes(filter) ||
                    mac.includes(filter) ||
                    status.includes(filter) ||
                    obs.includes(filter)
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

<style></style>

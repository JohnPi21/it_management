<template>
    <!-- NEW PICKING, POPUP, EDIT PICKING  -->
    <div id="page" class="container-fluid">
        <NewInventar
            v-if="modals.newInventar"
            @new-inventar="$toggleModal('newInventar')"
        />
        <EditInventar
            v-if="modals.editInventar"
            :edit-data="props.edit"
            @edit-inventar="$toggleModal('editInventar')"
        />
        <div class="page-title">
            <h1>Inventar</h1>
            <button class="g-button" @click="$toggleModal('newInventar')">
                Add Inventar
            </button>
        </div>
        <div class="h-bar">
            <button class="g-button" @click="$copyToClipboard('main-t')">
                Copy
            </button>
            <button
                class="g-button"
                @click="$exportTableToCSV('Tabel_Inventar.csv')"
            >
                CSV
            </button>
            <button class="g-button" @click="$printData('Inventar')">
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
                            @click="$toggleModal('editInventar', row)"
                            ><font-awesome-icon
                                icon="fa-solid fa-pen-to-square"
                        /></span>
                        <span
                            @click="$deleteRow(row.id, 'picking_inventar')"
                            class="icon"
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
import NewInventar from '~/components/createmodals/NewInventar.vue'
import EditInventar from '~/components/editmodals/EditInventar.vue'

export default {
    components: {
        NewInventar,
        EditInventar,
    },
    async asyncData({ $axios }) {
        const response = await $axios.$get('picking/read/picking_inventar')
        const rows = response

        return { rows }
    },

    data: () => ({
        modals: {
            newInventar: false,
            editInventar: false,
            columnFilter: false,
        },
        headers: [
            { name: 'id', status: true, display: 'ID' },
            { name: 'depozit', status: true, display: 'Depozit' },
            { name: 'telefon', status: true, display: 'Telefon' },
            { name: 'imei', status: true, display: 'IMEI' },
            { name: 'scaner', status: true, display: 'Scaner' },
            { name: 'sn', status: true, display: 'SN' },
            { name: 'ssn', status: true, display: 'SSN' },
            { name: 'nr_tel', status: true, display: 'Numar Telefon' },
            { name: 'user', status: true, display: 'User' },
            { name: 'data_trimis', status: true, display: 'Data Trimis' },
            { name: 'data_primit', status: false, display: 'Data Primit' },
            { name: 'obs', status: true, display: 'Obs' },
            { name: 'checked', status: false, display: 'Check' },
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
                const depozit = String(row.depozit).toLowerCase()
                const telefon = String(row.telefon).toLowerCase()
                const imei = String(row.imei).toLowerCase()
                const scaner = String(row.scaner).toLowerCase()
                const sn = String(row.sn).toLowerCase()
                const ssn = String(row.ssn).toLowerCase()
                const nr_tel = String(row.nr_tel).toLowerCase()
                const user = String(row.user).toLowerCase()
                const data_trimis = String(row.data_trimis).toLowerCase()
                const data_primit = String(row.data_primit).toLowerCase()
                const obs = String(row.obs).toLowerCase()
                const filter = this.actions.filter.toLowerCase()

                return (
                    id.includes(filter) ||
                    depozit.includes(filter) ||
                    telefon.includes(filter) ||
                    imei.includes(filter) ||
                    scaner.includes(filter) ||
                    sn.includes(filter) ||
                    ssn.includes(filter) ||
                    nr_tel.includes(filter) ||
                    user.includes(filter) ||
                    data_trimis.includes(filter) ||
                    data_primit.includes(filter) ||
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

<style lang="scss"></style>

<template>
    <!-- NEW PICKING, POPUP, EDIT PICKING  -->
    <div id="page" class="container-fluid">
        <div class="page-title">
            <h1>Scanere</h1>
            <button class="g-button" @click="$toggleModal('newScaner')">
                Actions
            </button>
        </div>
        <div class="h-bar">
            <button class="g-button" @click="$copyToClipboard('main-t')">
                Copy
            </button>
            <button
                class="g-button"
                @click="$exportTableToCSV('Tabel_Scaner.csv')"
            >
                CSV
            </button>
            <button class="g-button" @click="$printData('Scaner')">
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
                        <span v-if="head.name != 'value'">{{
                            row[head.name]
                        }}</span>
                        <span
                            v-if="head.name == 'value'"
                            v-for="(value, key) in row['value']"
                            >{{ key + ': ' + value }}<br
                        /></span>
                    </td>
                    <td v-if="actions.actions">
                        <span
                            class="icon"
                            @click="$toggleModal('editScaner', row)"
                            ><font-awesome-icon
                                icon="fa-solid fa-pen-to-square"
                        /></span>
                        <span
                            class="icon"
                            @click="$deleteRow(row.id, 'picking_scaner')"
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
import NewScaner from '~/components/createmodals/NewScaner.vue'
import EditScaner from '~/components/editmodals/EditScaner.vue'

export default {
    components: {
        NewScaner,
        EditScaner,
    },
    async asyncData({ $axios }) {
        const response = await $axios.$get('users/read/actions')
        const rows = response
        console.log(rows)

        return { rows }
    },

    data: () => ({
        modals: {
            newScaner: false,
            editScaner: false,
            columnFilter: false,
        },
        headers: [
            { name: 'id', status: true, display: 'ID' },
            { name: 'id_field', status: true, display: 'ID Camp' },
            { name: 'tabel', status: true, display: 'Tabel' },
            { name: 'value', status: true, display: 'Valuare' },
            { name: 'data_actiune', status: true, display: 'Data' },
            { name: 'id_user', status: true, display: 'User' },
            { name: 'actiune', status: true, display: 'Actiune' },
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
                const id_field = String(row.id_field).toLowerCase()
                const tabel = String(row.tabel).toLowerCase()
                const value = String(row.value).toLowerCase()
                const data_actiune = String(row.data_actiune).toLowerCase()
                const id_user = String(row.id_user).toLowerCase()
                const actiune = String(row.actiune).toLowerCase()
                const filter = this.actions.filter.toLowerCase()

                return (
                    id.includes(filter) ||
                    id_field.includes(filter) ||
                    tabel.includes(filter) ||
                    value.includes(filter) ||
                    data_actiune.includes(filter) ||
                    id_user.includes(filter) ||
                    actiune.includes(filter)
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

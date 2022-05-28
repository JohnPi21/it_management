<template>
    <div id="page" class="container-fluid">
        <NewSim v-if="modals.newSim" @new-sim="$toggleModal('newSim')" />
        <EditSim
            v-if="modals.editSim"
            :edit-data="props.edit"
            @edit-sim="$toggleModal('editSim')"
        />
        <div class="page-title">
            <h1>Sim</h1>
            <button class="g-button" @click="$toggleModal('newSim')">
                Add Sim
            </button>
        </div>
        <div class="h-bar">
            <button class="g-button" @click="$copyToClipboard('main-t')">
                Copy
            </button>
            <button
                class="g-button"
                @click="$exportTableToCSV('Tabel_Sim.csv')"
            >
                CSV
            </button>
            <button class="g-button" @click="$printData('Sim')">Print</button>
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
                    <th>ID</th>
                    <th
                        v-for="head in activeHeaders"
                        :key="head.id"
                        @click="
                            $sortItems(
                                head.name,
                                rows,
                                sortOrder,
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
                <tr v-for="(row, index) in limitRows" :key="row.id">
                    <td>{{ index }}</td>
                    <td v-for="head in activeHeaders" :key="head.id">
                        {{ row[head.name] }}
                    </td>
                    <td v-if="actions.actions">
                        <span class="icon" @click="$toggleModal('editSim', row)"
                            ><font-awesome-icon
                                icon="fa-solid fa-pen-to-square"
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
import NewSim from '~/components/createmodals/NewSim.vue'
import EditSim from '~/components/editmodals/EditSim.vue'

export default {
    components: {
        NewSim,
        EditSim,
    },
    async asyncData({ $axios }) {
        const rows = await $axios.$get('picking/read/picking_sim')
        return { rows }
    },

    data: () => ({
        modals: {
            newSim: false,
            editSim: false,
            columnFilter: false,
        },
        headers: [
            { name: 'id', status: false, display: 'ID' },
            { name: 'nr_tel', status: true, display: 'Numar Telefon' },
            { name: 'ip', status: true, display: 'IP' },
            { name: 'ssn', status: true, display: 'SSN' },
            { name: 'puk', status: true, display: 'PUK' },
            { name: 'status', status: true, display: 'Status' },
        ],
        actions: {
            sortOrder: 'asc',
            currentSort: '',
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
                const nrTel = String(row.nr_tel).toLowerCase()
                const ip = String(row.ip).toLowerCase()
                const ssn = String(row.ssn).toLowerCase()
                const puk = String(row.puk).toLowerCase()
                const status = String(row.status).toLowerCase()
                const filter = this.actions.filter

                return (
                    id.includes(filter) ||
                    nrTel.includes(filter) ||
                    ip.includes(filter) ||
                    puk.includes(filter) ||
                    status.includes(filter) ||
                    ssn.includes(filter)
                )
            })
        },
        limitRows() {
            return this.filteredRows.slice(0, this.actions.rowSize)
        },
        activeHeaders() {
            return this.headers.filter((head) => {
                return head.status == true
            })
        },
    },
}
</script>

<style></style>

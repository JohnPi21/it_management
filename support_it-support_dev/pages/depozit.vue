<template>
    <!-- NEW PICKING, POPUP, EDIT PICKING  -->
    <div id="page" class="container-fluid">
        <NewDepozit
            v-if="modals.newDepozit"
            @new-depozit="$toggleModal('newDepozit')"
        />
        <EditDepozit
            v-if="modals.editDepozit"
            :edit-data="props.edit"
            @edit-depozit="$toggleModal('editDepozit')"
        />
        <div class="page-title">
            <h1>Depozite</h1>
            <button class="g-button" @click="$toggleModal('newDepozit')">
                Add Depozit
            </button>
        </div>
        <div class="h-bar">
            <button class="g-button" @click="$copyToClipboard('main-t')">
                Copy
            </button>
            <button
                class="g-button"
                @click="$exportTableToCSV('Tabel_Depozit.csv')"
            >
                CSV
            </button>
            <button class="g-button" @click="$printData('Depozit')">
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
                        <span>{{ row[head.name] }}</span>
                    </td>
                    <td v-if="actions.actions">
                        <span
                            class="icon"
                            @click="$toggleModal('editService', row)"
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
import NewDepozit from '~/components/createmodals/NewDepozit.vue'
import EditDepozit from '~/components/editmodals/EditDepozit.vue'

export default {
    components: {
        NewDepozit,
        EditDepozit,
    },
    async asyncData({ $axios }) {
        const response = await $axios.$get('depozite/read/depozit')
        const rows = response

        return { rows }
    },

    data: () => ({
        modals: {
            newDepozit: false,
            editDepozit: false,
            columnFilter: false,
        },
        headers: [
            { name: 'id', status: true, display: 'ID' },
            { name: 'nume', status: true, display: 'Nume' },
            { name: 'tip', status: true, display: 'Tip' },
            { name: 'indicativ', status: true, display: 'Indicativ' },
            { name: 'adresa', status: true, display: 'Adresa' },
            { name: 'mail_depozit', status: true, display: 'Email depozit' },
            {
                name: 'telefon_depozit',
                status: true,
                display: 'Telefon depozit',
            },
            { name: 'sef_depozit', status: true, display: 'Sef depozit' },
            { name: 'mail_sef', status: true, display: 'Email sef' },
            { name: 'telefon_sef', status: true, display: 'Telefon Sef' },
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
                const nume = String(row.nume).toLowerCase()
                const tip = String(row.tip).toLowerCase()
                const indicativ = String(row.indicativ).toLowerCase()
                const adresa = String(row.adresa).toLowerCase()
                const telefon_depozit = String(
                    row.telefon_depozit
                ).toLowerCase()
                const sef_depozit = String(row.sef_depozit).toLowerCase()
                const mail_sef = String(row.mail_sef).toLowerCase()
                const telefon_sef = String(row.telefon_sef).toLowerCase()
                const filter = this.actions.filter.toLowerCase()

                return (
                    id.includes(filter) ||
                    nume.includes(filter) ||
                    tip.includes(filter) ||
                    indicativ.includes(filter) ||
                    adresa.includes(filter) ||
                    telefon_depozit.includes(filter) ||
                    sef_depozit.includes(filter) ||
                    mail_sef.includes(filter) ||
                    telefon_sef.includes(filter)
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
}
</script>

<style></style>

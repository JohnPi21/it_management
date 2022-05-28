<template>
    <!-- NEW PICKING, POPUP, EDIT PICKING  -->
    <div id="page" class="container-fluid">
        <NewPicking
            v-if="modals.newPicking"
            @new-picking="$toggleModal('newPicking')"
        />
        <EditPicking
            v-if="modals.editPicking"
            :edit-data="props.edit"
            @edit-picking="$toggleModal('editPicking')"
        />
        <div class="page-title">
            <h1>Picking</h1>
            <button class="g-button" @click="$toggleModal('newPicking')">
                Add Picking
            </button>
        </div>
        <div class="h-bar">
            <button class="g-button" @click="$copyToClipboard('main-t')">
                Copy
            </button>
            <button
                class="g-button"
                @click="$exportTableToCSV('Tabel_Picking.csv')"
            >
                CSV
            </button>
            <button class="g-button" @click="$printData('Picking')">
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
                            @click="$toggleModal('editPicking', row)"
                            ><font-awesome-icon
                                icon="fa-solid fa-pen-to-square"
                        /></span>
                        <span
                            class="icon"
                            @click="$deleteRow(row.id, 'picking')"
                            ><font-awesome-icon icon="fa-solid fa-trash-can"
                        /></span>
                        <span
                            class="icon"
                            @click="$check('picking', row.id)"
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
import NewPicking from '~/components/createmodals/NewPicking.vue'
import EditPicking from '~/components/editmodals/EditPicking.vue'

export default {
    components: {
        NewPicking,
        EditPicking,
    },
    async asyncData({ $axios }) {
        const rows = await $axios
            .$get('picking/read/picking')
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
            newPicking: false,
            editPicking: false,
            columnFilter: false,
        },
        headers: [
            { name: 'id', status: true, display: 'ID' },
            { name: 'depozit', status: true, display: 'Depozit' },
            { name: 'cuseta', status: true, display: 'Cuseta' },
            { name: 'telefon', status: true, display: 'Telefon' },
            { name: 'imei', status: true, display: 'IMEI' },
            { name: 'scaner', status: true, display: 'Scaner' },
            { name: 'sn', status: true, display: 'SN' },
            { name: 'ssn', status: true, display: 'SSN' },
            { name: 'nr_tel', status: true, display: 'Numar Telefon' },
            { name: 'user', status: true, display: 'User' },
            { name: 'tel_user', status: true, display: 'Telefon user' },
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
                const cuseta = String(row.cuseta).toLowerCase()
                const telefon = String(row.telefon).toLowerCase()
                const imei = String(row.imei).toLowerCase()
                const scaner = String(row.scaner).toLowerCase()
                const sn = String(row.sn).toLowerCase()
                const ssn = String(row.ssn).toLowerCase()
                const nr_tel = String(row.nr_tel).toLowerCase()
                const user = String(row.user).toLowerCase()
                const tel_user = String(row.tel_user).toLowerCase()
                const obs = String(row.obs).toLowerCase()
                const filter = this.actions.filter.toLowerCase()

                return (
                    id.includes(filter) ||
                    depozit.includes(filter) ||
                    cuseta.includes(filter) ||
                    telefon.includes(filter) ||
                    imei.includes(filter) ||
                    scaner.includes(filter) ||
                    sn.includes(filter) ||
                    ssn.includes(filter) ||
                    nr_tel.includes(filter) ||
                    user.includes(filter) ||
                    tel_user.includes(filter) ||
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

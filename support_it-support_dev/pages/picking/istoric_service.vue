<template>
    <!-- NEW PICKING, POPUP, EDIT PICKING  -->
    <div id="page" class="container-fluid">
        <!-- <NewService
            v-if="modals.newService"
            @new-service="$toggleModal('newService')"
        />
        <EditService
            v-if="modals.editService"
            :edit-data="props.edit"
            @edit-service="$toggleModal('editService')"
        /> -->
        <div class="page-title">
            <h1>Istoric Service</h1>
            <!-- <button class="g-button" @click="$toggleModal('newService')">
                Add Service
            </button> -->
        </div>
        <div class="h-bar">
            <button class="g-button" @click="$copyToClipboard('main-t')">
                Copy
            </button>
            <button
                class="g-button"
                @click="$exportTableToCSV('Tabel_Service.csv')"
            >
                CSV
            </button>
            <button class="g-button" @click="$printData('Service')">
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
                <tr
                    v-for="row in limitRows"
                    :key="row.id"
                    :class="{ pending: row.status == 'PENDING' }"
                >
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
                            @click="$deleteRow(row.id, 'picking_service')"
                            ><font-awesome-icon icon="fa-solid fa-trash-can"
                        /></span>
                        <span
                            class="icon"
                            @click="$check('picking_service', row.id)"
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
import NewService from '~/components/createmodals/NewService.vue'
import EditService from '~/components/editmodals/EditService.vue'

export default {
    components: {
        NewService,
        EditService,
    },
    async asyncData({ $axios }) {
        const response = await $axios.$get(
            'picking/read/picking_istoric_service'
        )
        const rows = response

        return { rows }
    },

    data: () => ({
        modals: {
            newService: false,
            editService: false,
            columnFilter: false,
        },
        headers: [
            { name: 'id', status: true, display: 'ID' },
            { name: 'depozit', status: true, display: 'Depozit' },
            { name: 'tag', status: true, display: 'Tag' },
            { name: 'sn', status: true, display: 'SN' },
            { name: 'imei', status: true, display: 'IMEI' },
            { name: 'service', status: true, display: 'Service' },
            { name: 'obs', status: true, display: 'Obs' },
            { name: 'status', status: true, display: 'Status' },
            { name: 'data_trimis', status: true, display: 'Trimis' },
            { name: 'data_primit', status: true, display: 'Primit' },
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
                const tag = String(row.tag).toLowerCase()
                const sn = String(row.sn).toLowerCase()
                const imei = String(row.imei).toLowerCase()
                const service = String(row.service).toLowerCase()
                const obs = String(row.obs).toLowerCase()
                const status = String(row.status).toLowerCase()
                const data_trimis = String(row.data_trimis).toLowerCase()
                const data_primit = String(row.data_primit).toLowerCase()
                const filter = this.actions.filter.toLowerCase()

                return (
                    id.includes(filter) ||
                    depozit.includes(filter) ||
                    tag.includes(filter) ||
                    sn.includes(filter) ||
                    imei.includes(filter) ||
                    service.includes(filter) ||
                    obs.includes(filter) ||
                    status.includes(filter) ||
                    data_trimis.includes(filter) ||
                    data_primit.includes(filter)
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

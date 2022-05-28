<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('switch-port')"></div>
        <div class="container modal">
            <PageTitle :title="'GS2200-8-01'" :color="'black'" />
            <div class="table-container">
                <img id="switch-img" src="~/assets/images/switch-image.svg" />
                <div class="port-table">
                    <div class="h-bar">
                        <button
                            class="g-button"
                            @click="$copyToClipboard('main-t')"
                        >
                            Copy
                        </button>
                        <button
                            class="g-button"
                            @click="$exportTableToCSV('Tabel_Sim.csv')"
                        >
                            CSV
                        </button>
                        <button class="g-button" @click="$printData('Sim')">
                            Print
                        </button>
                        <div class="col-list-container">
                            <button
                                class="g-button"
                                @click="
                                    modals.columnFilter = !modals.columnFilter
                                "
                            >
                                Column Visibility
                            </button>
                            <div
                                v-if="modals.columnFilter"
                                class="column-toggle"
                            >
                                <span
                                    v-for="head in headers"
                                    :key="head.id"
                                    @click="$showColumns(head.name)"
                                    >{{ head.display }}</span
                                >
                                <span
                                    @click="actions.actions = !actions.actions"
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
                                            sortOrder,
                                            actions.currentSort
                                        )
                                    "
                                >
                                    {{ head.display }}
                                    <font-awesome-icon
                                        v-if="
                                            actions.currentSort == head.name &&
                                            actions.sortOrder == 'asc'
                                        "
                                        :icon="['fa', 'sort-amount-down-alt']"
                                        :class="'icons'"
                                    />
                                    <font-awesome-icon
                                        v-if="
                                            actions.currentSort == head.name &&
                                            actions.sortOrder == 'desc'
                                        "
                                        :icon="['fa', 'sort-amount-up-alt']"
                                        :class="'icons'"
                                    />
                                </th>
                                <th v-if="actions.actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--################ TABLE BODY ################# -->
                            <tr v-for="row in limitRows" :key="row.id">
                                <td
                                    v-for="head in activeHeaders"
                                    :key="head.id"
                                >
                                    {{ row[head.name] }}
                                </td>
                                <td v-if="actions.actions">
                                    <font-awesome-icon
                                        :icon="['fa', 'edit']"
                                        :class="'icons'"
                                        @click="$toggleModal('editSim', row)"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PageTitle from '~/components/ui/PageTitle.vue'
export default {
    components: {
        PageTitle,
    },
    data: () => ({
        modals: {
            newSim: false,
            editSim: false,
            columnFilter: false,
        },
        headers: [
            { name: 'id', status: true, display: 'ID' },
            { name: 'nume', status: true, display: 'Nume' },
            { name: 'port', status: true, display: 'Port' },
            { name: 'tag', status: true, display: 'Tag' },
            { name: 'status', status: true, display: 'Status' },
            { name: 'vlan', status: true, display: 'VLAN' },
            { name: 'viteza', status: true, display: 'Viteza' },
        ],
        actions: {
            sortOrder: 'asc',
            currentSort: '',
            filter: '',
            actions: true,
            rowSize: 19,
        },
        rows: [
            {
                id: 1,
                nume: 'GS2200-8-01',
                port: 1,
                tag: 'AT1186',
                status: 'ACTIV',
                vlan: '203, 98, 93',
                viteza: 1,
            },
            {
                id: 2,
                nume: 'GS2200-8-01',
                port: 2,
                tag: 'AT1185',
                status: 'ACTIV',
                vlan: '203, 98, 93',
                viteza: 1,
            },
            {
                id: 3,
                nume: 'GS2200-8-01',
                port: 3,
                tag: 'N/C',
                status: 'INACTIV',
                vlan: '',
                viteza: '',
            },
            {
                id: 4,
                nume: 'GS2200-8-01',
                port: 4,
                tag: 'AT1049',
                status: 'ACTIV',
                vlan: '203, 98, 93',
                viteza: '1',
            },
            {
                id: 5,
                nume: 'GS2200-8-01',
                port: 5,
                tag: 'N/C',
                status: 'INACTIV',
                vlan: '',
                viteza: '',
            },
            {
                id: 6,
                nume: 'GS2200-8-01',
                port: 6,
                tag: 'N/C',
                status: 'INACTIV',
                vlan: '',
                viteza: '',
            },
            {
                id: 7,
                nume: 'GS2200-8-01',
                port: 7,
                tag: 'AT1181',
                status: 'ACTIV',
                vlan: '203, 98, 93',
                viteza: '1',
            },
            {
                id: 8,
                nume: 'GS2200-8-01',
                port: 8,
                tag: 'N/C',
                status: 'INACTIV',
                vlan: '',
                viteza: '',
            },
            {
                id: 9,
                nume: 'GS2200-8-01',
                port: 9,
                tag: 'GS2210-8-12',
                status: 'ACTIV',
                vlan: '203, 98, 93',
                viteza: '1',
            },
            {
                id: 10,
                nume: 'GS2200-8-01',
                port: 10,
                tag: 'XS3700-24-01',
                status: 'ACTIV',
                vlan: '203, 98, 93',
                viteza: '1',
            },
        ],
    }),
    // async fetch() {
    //     const devices = ['telefon', 'sim', 'scaner', 'cuseta', 'depozit']
    //     for (let i = 0; i < devices.length; i++) {
    //         const element = await this.$axios.$get(
    //             'picking/vuex/' + devices[i]
    //         )
    //         this.$store.commit('set_picking', [devices[i], element])
    //     }
    // },

    computed: {
        filteredRows() {
            return this.rows.filter((row) => {
                const id = String(row.id).toLowerCase()
                const nume = String(row.nume).toLowerCase()
                const port = String(row.port).toLowerCase()
                const tag = String(row.tag).toLowerCase()
                const status = String(row.status).toLowerCase()
                const vlan = String(row.vlan).toLowerCase()
                const filter = this.actions.filter

                return (
                    id.includes(filter) ||
                    nume.includes(filter) ||
                    port.includes(filter) ||
                    tag.includes(filter) ||
                    vlan.includes(filter) ||
                    status.includes(filter)
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

    methods: {},
}
</script>

<style lang="scss" scoped>
.modal-container {
    z-index: 250;
}
.modal {
    background-color: rgb(255, 255, 255);
    height: 85%;
}

#switch-img {
    width: 100%;
    height: 15vh;
    margin-top: -25px;
}
.table-container {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.port-table {
    width: 100%;

    .main-table {
        margin-top: 5px;
        border-radius: 3px;
    }
}
</style>

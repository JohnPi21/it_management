<template>
    <div id="page" class="container-fluid">
        <NewSim v-if="modals.newSim" @new-sim="$toggleModal('newSim')" />
        <EditSim
            v-if="modals.editSim"
            :edit-data="props.edit"
            @edit-sim="$toggleModal('editSim')"
        />
        <div class="page-title">
            <h1>Pc</h1>
            <button class="g-button" @click="$toggleModal('newSim')">
                Add Pc
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
                <span @click="actions.actions = !actions.actions">Actions</span>
            </div>

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
                    <td v-for="head in activeHeaders" :key="head.id">
                        <a :href="row.link">{{ row[head.name] }}</a>
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
    data: () => ({
        modals: {
            newSim: false,
            editSim: false,
            columnFilter: false,
        },
        rows: [
            {
                id: 1,
                tag: 'AT1530',
                type: 'Laptop',
                marca: 'LENOVO',
                mac: '64:00:6a:31:67:48',
                model: 'V330-15IKB',
                sn: 'SR90PQKJB',
                locatie: 'Timisoara',
                status: 'UZ',
                link: 'https://drive.google.com/file/d/1N8zzWCxrG0EVIZWudLD2aZW8EMgxtO6t/view?usp=sharing',
            },
            {
                id: 2,
                tag: 'AT1287',
                type: 'Server',
                marca: 'Dell',
                mac: '18:fb:7b:a7:8e:85 ',
                model: '',
                sn: '',
                locatie: 'Vrzs',
                status: 'uz',
                link: 'https://drive.google.com/file/d/1Hbp4_CRKHoDGEPGGvidbrR-0-XCkeg2P/view?usp=sharing',
            },
            {
                id: 3,
                tag: 'AT1240',
                type: 'Desktop',
                marca: 'DELL',
                mac: '6c:2b:59:ed:a6:82 ',
                model: 'OptiPlex 3060',
                sn: 'heksrokpk12kpgd',
                locatie: 'IMGB',
                status: 'UZ',
                link: 'https://drive.google.com/file/d/19IbWP4eZ8qxnmRAJdfsL0FJv_NZhV2YA/view?usp=sharing',
            },
            {
                id: 4,
                tag: 'AT1531',
                type: 'Laptop',
                marca: 'DELL',
                mac: '64:00:6a:2a:58:49',
                model: 'OptiPlex 3020',
                sn: '',
                locatie: 'IMGB',
                status: 'UZ',
                link: 'https://drive.google.com/file/d/1rEjm27Kb2fD5yExpRkdkUcdCzTUU35wz/view?usp=sharing',
            },
            {
                id: 5,
                tag: 'AT1732',
                type: 'Latpop',
                marca: 'HUAWEI',
                mac: '9c:29:76:23:19:73',
                model: 'MateBook X PRO 2021',
                sn: '7UTBB21311801042',
                locatie: 'IMGB',
                status: 'UZ',
                link: 'https://drive.google.com/file/d/1GUQb6gSGuyJpFagl4HL9B7DTiEG38GwE/view?usp=sharing',
            },
            {
                id: 6,
                tag: 'AT1321',
                type: 'Laptop',
                marca: 'LENOVO',
                mac: '54:ee:75:eb:31:71',
                model: 'V330-15IKB',
                sn: 'SR90PNLE1',
                locatie: 'IMGB',
                status: 'UZ',
                link: 'https://drive.google.com/file/d/1koTSWeG2EjOViGH2Px89VR0nJ_SbD1nZ/view?usp=sharing',
            },
            {
                id: 7,
                tag: 'AT1470',
                type: 'Desktop',
                marca: 'Dell',
                mac: 'e4:54:e8:da:7f:3c',
                model: 'OptiPlex 3070',
                sn: '',
                locatie: 'Verzisori',
                status: 'UZ',
                link: 'https://drive.google.com/file/d/1Uke07v-chKr1OZpf6e1CdJ6DP61vpuxM/view?usp=sharing',
            },
            {
                id: 8,
                tag: 'AT1290',
                type: 'Server',
                marca: 'Dell',
                mac: '18:fb:7b:9c:a6:ab  ',
                model: '',
                sn: '',
                locatie: 'IMGB',
                status: 'UZ',
                link: 'https://drive.google.com/file/d/10j0S-vqVYcx6Md-AoAvLP--YCQ9gxnEf/view?usp=sharing',
            },
            {
                id: 9,
                tag: 'PRN0781',
                type: 'Imprimanta',
                marca: 'Kyocera',
                mac: '00:17:c8:1d:8a:ee',
                model: 'P2135dn',
                sn: 'LVL5483565',
                locatie: 'Valcea',
                status: 'UZ',
                link: 'https://drive.google.com/file/d/1_mACw00f9s6X_Tviju-w7uZqjVLFJDFy/view?usp=sharing',
            },
            {
                id: 10,
                tag: 'PRN0572',
                type: 'Imprimanta',
                marca: 'EPSON',
                mac: '64:eb:8c:23:d1:33',
                model: 'L550',
                sn: '',
                locatie: 'Focsani',
                status: 'UZ',
                link: 'https://drive.google.com/file/d/1w9NAXTTUI4i7wmMs3pY6Ww5Ogf_GsWFf/view?usp=sharing',
            },
        ],
        headers: [
            { name: 'id', status: true, display: 'ID' },
            { name: 'tag', status: true, display: 'Tag' },
            { name: 'type', status: true, display: 'Type' },
            { name: 'marca', status: true, display: 'Marca' },
            { name: 'mac', status: true, display: 'MAC' },
            { name: 'model', status: true, display: 'Model' },
            { name: 'sn', status: true, display: 'SN' },
            { name: 'locatie', status: true, display: 'Locatie' },
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
                const tag = String(row.tag).toLowerCase()
                const type = String(row.type).toLowerCase()
                const marca = String(row.marca).toLowerCase()
                const model = String(row.model).toLowerCase()
                const locatie = String(row.locatie).toLowerCase()
                const sn = String(row.sn).toLowerCase()
                const status = String(row.status).toLowerCase()
                const filter = this.actions.filter

                return (
                    id.includes(filter) ||
                    tag.includes(filter) ||
                    type.includes(filter) ||
                    marca.includes(filter) ||
                    locatie.includes(filter) ||
                    sn.includes(filter) ||
                    status.includes(filter) ||
                    model.includes(filter)
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

<style>
a {
    text-decoration: none;
}
</style>

<template>
    <div id="page">
        <div class="container-fluid page-title">
            <h1>Imprimante</h1>
            <button>Add Imprimanta</button>
        </div>
        <div class="t-container">
            <div class="input-c">
                <div class="buttons">
                    <button @click="$copyToClipboard('main-t')">Copy</button>
                    <button @click="$exportTableToCSV('Tabel_PC.csv')">
                        CSV
                    </button>
                    <button @click="$printData('Pc')">Print</button>
                    <button @click="columnFilter = !columnFilter">
                        <span>Column Visibility</span>
                        <div v-if="columnFilter" class="column-filter">
                            <span
                                v-for="(value, key) in headers"
                                :key="key.id"
                                @click="showColumns(key)"
                                >{{
                                    key.charAt(0).toUpperCase() + key.slice(1)
                                }}</span
                            >
                        </div>
                    </button>
                </div>
                <input v-model="filter" type="text" placeholder="Search Item" />
            </div>
            <table id="main-t" ref="printTable" class="main-table">
                <!--################ TABLE HEAD ################# -->
                <thead>
                    <tr>
                        <th
                            v-for="(value, key) in activeHeaders"
                            :key="key.id"
                            @click="
                                $sortItems(key, rows, sortOrder, currentSort)
                            "
                        >
                            {{ key.charAt(0).toUpperCase() + key.slice(1) }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!--################ TABLE BODY ################# -->
                    <tr v-for="row in filteredRows" :key="row.id">
                        <!-- <td v-for="(value, key) in row" :key="key.id">
                            {{ value }}
                        </td> -->
                        <td v-if="headers.tag">{{ row.tag }}</td>
                        <td v-if="headers.type">{{ row.type }}</td>
                        <td v-if="headers.name">{{ row.name }}</td>
                        <td v-if="headers.model">{{ row.model }}</td>
                        <td v-if="headers.sn">{{ row.sn }}</td>
                        <td v-if="headers.locatie">{{ row.locatie }}</td>
                        <td v-if="headers.status">{{ row.status }}</td>
                        <td v-if="headers.actions" class="actions">
                            <font-awesome-icon
                                :icon="['fa', 'edit']"
                                :class="'icons'"
                            />
                            <font-awesome-icon
                                :icon="['fa', 'eye']"
                                :class="'icons'"
                            />
                            <font-awesome-icon
                                :icon="['fa', 'trash-alt']"
                                :class="'icons'"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        headers: {
            tag: true,
            type: true,
            name: true,
            model: true,
            sn: true,
            locatie: true,
            status: true,
            actions: true,
        },
        sortOrder: 'asc',
        currentSort: '',
        filter: '',
        columnFilter: false,
        rows: [
            {
                tag: 'AT1530',
                type: 'Desktop',
                name: 'Desktop Asus',
                model: 'dsktasus213',
                sn: '355hdsf65814385423',
                locatie: 'IMGB',
                status: 'test',
            },
        ],
    }),
    computed: {
        filteredRows() {
            return this.rows.filter((row) => {
                const tag = row.tag.toString().toLowerCase()
                const type = row.type.toString().toLowerCase()
                const name = row.name.toString().toLowerCase()
                const model = row.model.toString().toLowerCase()
                const locatie = row.locatie.toString().toLowerCase()
                const status = row.status.toString().toLowerCase()
                const filter = this.filter.toLowerCase()
                return (
                    tag.includes(filter) ||
                    type.includes(filter) ||
                    name.includes(filter) ||
                    model.includes(filter) ||
                    locatie.includes(filter) ||
                    status.includes(filter)
                )
            })
        },

        activeHeaders() {
            const headerArr = Object.entries(this.headers)
            const filterArr = headerArr.filter(([key, value]) => value == true)
            return Object.fromEntries(filterArr)
        },
    },
    methods: {
        showColumns(key) {
            this.headers[key] = !this.headers[key]
        },
    },
}
</script>

<style></style>

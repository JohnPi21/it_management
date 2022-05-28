import Vue from 'vue'
Vue.prototype.$sortItems = sortItems
Vue.prototype.$copyToClipboard = copyToClipboard
Vue.prototype.$exportTableToCSV = exportTableToCSV
Vue.prototype.$printData = printData
Vue.prototype.$showColumns = showColumns
Vue.prototype.$fullSize = fullSize

function fullSize() {
    this.actions.rowSize = this.filteredRows.length
}

function showColumns(key) {
    this.headers.forEach((head) => {
        if (head.name == key) {
            head.status = !head.status
        }
    })
}

function assetSort(key, rows) {
    return rows.sort(function (a, b) {
        const nameA = a[key]
        const nameB = b[key]
        if (nameA === null) {
            return 1
        }
        if (nameB === null) {
            return -1
        }
        if (nameA < nameB) {
            return -1
        }
        if (nameA > nameB) {
            return 1
        }
        return 0
    })
}

function sortItems(key, rows, sortOrder, currentSort) {
    if (this.actions.sortOrder == 'asc' && this.actions.currentSort == key) {
        this.actions.sortOrder = 'desc'
        assetSort(key, rows).reverse()
    } else if (
        this.actions.sortOrder == 'desc' &&
        this.actions.currentSort == key
    ) {
        this.actions.sortOrder = 'asc'
        assetSort(key, rows)
    } else {
        this.actions.sortOrder = 'asc'
        assetSort(key, rows)
        this.actions.currentSort = key
    }
}

/// Copy to clipboard
function copyToClipboard(containerid) {
    const range = document.createRange()
    const containerNode = document.getElementById(containerid)
    range.selectNode(containerNode)
    window.getSelection().removeAllRanges()
    window.getSelection().addRange(range)
    document.execCommand('copy')
    window.getSelection().removeAllRanges()
    alert('Data copied')
}

// Download as CSV
function downloadCSV(csv, filename) {
    let csvFile
    let downloadLink

    // CSV file
    csvFile = new Blob([csv], { type: 'text/csv' })

    // Download link
    downloadLink = document.createElement('a')

    // File name
    downloadLink.download = filename

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile)

    // Hide download link
    downloadLink.style.display = 'none'

    // Add the link to DOM
    document.body.appendChild(downloadLink)

    // Click download link
    downloadLink.click()
}

function exportTableToCSV(filename) {
    let csv = []
    let rows = document.querySelectorAll('table tr')

    for (let i = 0; i < rows.length; i++) {
        let row = [],
            cols = rows[i].querySelectorAll('td, th')

        for (let j = 0; j < cols.length; j++) row.push(cols[j].innerText)

        csv.push(row.join(','))
    }

    // Download CSV file
    downloadCSV(csv.join('\n'), filename)
}

// Print Table

function printData(header) {
    const divToPrint = this.$refs.printTable
    const tableStype = `<style>
        .main-table{
            border-right: 1px solid #515963;
            border-bottom: 1px solid #515963;
            text-align: left;
            border-collapse: collapse;
        }
        .main-table td,
        th {
            padding: 10px;
            border-left: 1px solid #515963;
            border-top: 1px solid #515963;
            }
    </style>`
    const newWin = window.open('')
    newWin.document.write(
        `<!DOCTYPE html>
        <html>
            <head>
                ${tableStype}
            </head>
            <body>
                <h1>${header}</h1>
                ${divToPrint.outerHTML}
            </body>
        </html>`
    )
    newWin.print()
    newWin.close()
}

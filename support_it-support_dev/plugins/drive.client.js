// import Vue from 'vue'
// Vue.prototype.$listFiles = listFiles

// handleClientLoad()
// // Client ID and API key from the Developer Console
// const CLIENT_ID =
//     '663007211940-0it87vcaprmgfdb8lq3fa7vd50vppr20.apps.googleusercontent.com'
// const API_KEY = 'AIzaSyBuvHpDBmAQjMToim4V_QFZ8vvHmkczMwA'

// var DISCOVERY_DOCS = [
//     'https://www.googleapis.com/discovery/v1/apis/drive/v3/rest',
// ]

// // Authorization scopes required by the API; multiple scopes can be
// // included, separated by spaces.
// var SCOPES = [
//     'https://www.googleapis.com/auth/drive.metadata.readonly,  https://www.googleapis.com/auth/drive',
// ]

// function handleClientLoad() {
//     gapi.load('client:auth2', initClient)
// }

// function initClient() {
//     gapi.client.init({
//         apiKey: API_KEY,
//         clientId: CLIENT_ID,
//         discoveryDocs: DISCOVERY_DOCS,
//         scope: SCOPES,
//     })
// }

// function listFiles(list, res) {
//     gapi.client.drive.files
//         .list({
//             supportsAllDrives: true,
//             includeItemsFromAllDrives: true,
//             useDomainAdminAccess: true,
//             q: "parents in '1isD5Gi29MwxnX2V-tTSWObYc-zL0SLS8'",
//         })
//         .then(function (response) {
//             let ids = []
//             for (const [key, value] of Object.entries(response.result.files)) {
//                 ids.push(value.id)
//             }
//             ids.forEach((res) => {
//                 console.log('https://drive.google.com/drive/folders/' + res)
//             })
//         })
// }

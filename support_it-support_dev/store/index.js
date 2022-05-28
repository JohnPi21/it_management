export const state = () => ({
    picking: {
        telefon: [],
        scaner: [],
        depozit: [],
        sim: [],
        cuseta: [],
    },
    ui: {
        navbar: true,
        info: [],
    },
    network: {},
    auth: {},
})

export const mutations = {
    set_picking(state, payload) {
        state.picking[payload[0]] = payload[1]
    },
    toggle(state, el) {
        state.ui[el] = !state.ui[el]
    },
    set_ui(state, payload) {
        state.ui[payload[0]] = payload[1]
    },
    set_auth(state, payload) {
        state.auth = payload
    },
}

export const getters = {
    filterAsset: (state) => (asset) => {
        return state.picking[asset[0]].filter((device) => {
            const tag = String(device.tag).toLowerCase()
            const imei = String(device.imei).toLowerCase()
            const imei2 = String(device.imei2).toLowerCase()
            const ssn = String(device.ssn).toLowerCase()
            const sn = String(device.sn).toLowerCase()
            return (
                tag.includes(asset[1].toLowerCase()) ||
                imei.includes(asset[1].toLowerCase()) ||
                imei2.includes(asset[1].toLowerCase()) ||
                ssn.includes(asset[1].toLowerCase()) ||
                sn.includes(asset[1].toLowerCase())
            )
        })
    },
}

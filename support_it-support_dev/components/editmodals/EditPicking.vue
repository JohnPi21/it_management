<template>
    <div class="modal-container">
        <div class="modal-bk" @click="$emit('edit-picking')"></div>
        <div class="container modal" @click="$closeModals($event)">
            <h3>Edit Picking</h3>
            <!-- <div class="grid-container"></div> E containerul randurilor de input 1 display <=>1 edit -->

            <!--################ simple current data container ################-->
            <!-- <div class="input-container">
                    <input :value="propData.telefon" readonly type="text" />
                    <label>Telefon</label>
                </div> -->

            <!--################  Current data container with delete function  ############## -->
            <!-- <div class="input-container">
                    <input :value="propData.ip" readonly type="text" />
                    <label for="ip">IP</label>
                    <span class="delete" @click="$deleteData('ip', 'picking')"
                        ><font-awesome-icon icon="fa-solid fa-xmark"
                    /></span>
                </div> -->
            <!-- ############### DROPDOWN LIST INPUT SELECT ############# -->
            <!-- <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="selectedData.status"
                            readonly
                            :inp="selectedData.status"
                            type="text"
                            @click="$toggleModal('status')"
                        />
                        <label for="status">Status</label>
                    </div>
                    <div v-show="modals.status" class="list-container">
                        <input ref="status" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="telefon in $store.getters.filterAsset([
                                    'depozit',
                                    actions.filter,
                                ])"
                                :key="telefon.id"
                                @click="$selectData(telefon.tag, 'status')"
                                >{{ telefon.tag }}
                                <font-awesome-icon
                                    :icon="['fa', 'plus-circle']"
                                    class="icon"
                                />
                            </span>
                        </div>
                    </div>
                </div> -->
            <!-- ################ SIMPLE INPUT DATA ############### -->
            <!-- <div class="input-container">
                    <input
                        v-model="selectedData.puk"
                        :inp="selectedData.puk"
                        type="text"
                    />
                    <label for="puk">PUK</label>
                </div> -->
            <div class="grid-container">
                <div class="input-container">
                    <input :value="propData.telefon" readonly type="text" />
                    <label>Telefon</label>
                </div>
                <div class="input-container">
                    <input :value="propData.scaner" readonly type="text" />
                    <label>Scaner</label>
                </div>
                <div class="input-container">
                    <input :value="propData.nr_tel" readonly type="text" />
                    <label>SIM</label>
                </div>
                <div class="input-container">
                    <input :value="propData.depozit" readonly type="text" />
                    <label>Depozit</label>
                </div>
                <div class="input-container">
                    <input :value="propData.cuseta" readonly type="text" />
                    <label>Cuseta</label>
                </div>
                <div class="input-container">
                    <input :value="propData.user" readonly type="text" />
                    <label for="user">User</label>
                    <span class="delete" @click="$deleteData('user', 'picking')"
                        ><font-awesome-icon icon="fa-solid fa-xmark"
                    /></span>
                </div>
                <div class="input-container">
                    <input :value="propData.tel_user" readonly type="text" />
                    <label for="tel_user">Telefon User</label>
                    <span
                        class="delete"
                        @click="$deleteData('tel_user', 'picking')"
                        ><font-awesome-icon icon="fa-solid fa-xmark"
                    /></span>
                </div>
            </div>
            <div class="grid-container">
                <!-- ############ STATUS TELEFON ############## -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="selectedData.status_telefon"
                            readonly
                            :inp="selectedData.status_telefon"
                            type="text"
                            @click="$toggleModal('status_telefon')"
                        />
                        <label for="status">Status Telefon</label>
                    </div>
                    <div v-show="modals.status_telefon" class="list-container">
                        <input ref="status_telefon" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="stat in status.device"
                                :key="stat.id"
                                @click="$selectData(stat, 'status_telefon')"
                                >{{ stat }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############  TELEFON ############## -->
                <div
                    v-show="selectedData.status_telefon != ''"
                    class="input-list-container"
                >
                    <div class="input-container">
                        <input
                            v-model="newName.telefon"
                            readonly
                            :inp="newName.telefon"
                            type="text"
                            @click="$toggleModal('telefon')"
                        />
                        <label for="telefon">Telefon</label>
                    </div>
                    <div v-show="modals.telefon" class="list-container">
                        <input ref="telefon" v-model="actions.filter" />
                        <div class="el-container">
                            <span @click="$selectData('NECUNOSCUT', 'telefon')"
                                >Necunoscut</span
                            >
                            <span
                                v-for="telefon in $store.getters.filterAsset([
                                    'telefon',
                                    actions.filter,
                                ])"
                                :key="telefon.id"
                                @click="$selectData(telefon.id, 'telefon')"
                                >{{ telefon.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############ STATUS SCANER ############## -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="selectedData.status_scaner"
                            readonly
                            :inp="selectedData.status_scaner"
                            type="text"
                            @click="$toggleModal('status_scaner')"
                        />
                        <label for="status">Status Scaner</label>
                    </div>
                    <div v-show="modals.status_scaner" class="list-container">
                        <input ref="status_scaner" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="stat in status.device"
                                :key="stat.id"
                                @click="$selectData(stat, 'status_scaner')"
                                >{{ stat }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############  SCANER ############## -->
                <div
                    v-show="selectedData.status_scaner != ''"
                    class="input-list-container"
                >
                    <div class="input-container">
                        <input
                            v-model="newName.scaner"
                            readonly
                            :inp="newName.scaner"
                            type="text"
                            @click="$toggleModal('scaner')"
                        />
                        <label for="scaner">Scaner</label>
                    </div>
                    <div v-show="modals.scaner" class="list-container">
                        <input ref="scaner" v-model="actions.filter" />
                        <div class="el-container">
                            <span @click="$selectData('NECUNOSCUT', 'scaner')"
                                >Necunoscut</span
                            >
                            <span
                                v-for="scaner in $store.getters.filterAsset([
                                    'scaner',
                                    actions.filter,
                                ])"
                                :key="scaner.id"
                                @click="$selectData(scaner.id, 'scaner')"
                                >{{ scaner.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############ STATUS SIM ############## -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="selectedData.status_sim"
                            readonly
                            :inp="selectedData.status_sim"
                            type="text"
                            @click="$toggleModal('status_sim')"
                        />
                        <label for="status">Status SIM</label>
                    </div>
                    <div v-show="modals.status_sim" class="list-container">
                        <input ref="status_sim" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="stat in status.sim"
                                :key="stat.id"
                                @click="$selectData(stat, 'status_sim')"
                                >{{ stat }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############  SIM ############## -->
                <div
                    v-show="selectedData.status_sim != ''"
                    class="input-list-container"
                >
                    <div class="input-container">
                        <input
                            v-model="newName.sim"
                            readonly
                            :inp="newName.sim"
                            type="text"
                            @click="$toggleModal('sim')"
                        />
                        <label for="sim">SIM</label>
                    </div>
                    <div v-show="modals.sim" class="list-container">
                        <input ref="sim" v-model="actions.filter" />
                        <div class="el-container">
                            <span @click="$selectData('NECUNOSCUT', 'sim')"
                                >Necunoscut</span
                            >
                            <span
                                v-for="sim in $store.getters.filterAsset([
                                    'sim',
                                    actions.filter,
                                ])"
                                :key="sim.id"
                                @click="$selectData(sim.id, 'sim')"
                                >{{ sim.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############  DEPOZIT ############## -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="newName.depozit"
                            readonly
                            :inp="newName.depozit"
                            type="text"
                            @click="$toggleModal('depozit')"
                        />
                        <label for="depozit">Depozit</label>
                    </div>
                    <div v-show="modals.depozit" class="list-container">
                        <input ref="depozit" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="depozit in $store.getters.filterAsset([
                                    'depozit',
                                    actions.filter,
                                ])"
                                :key="depozit.id"
                                @click="$selectData(depozit.id, 'depozit')"
                                >{{ depozit.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############ STATUS CUSETA ############## -->
                <div class="input-list-container">
                    <div class="input-container">
                        <input
                            v-model="selectedData.status_cuseta"
                            readonly
                            :inp="selectedData.status_cuseta"
                            type="text"
                            @click="$toggleModal('status_cuseta')"
                        />
                        <label for="cuseta">Status Cuseta</label>
                    </div>
                    <div v-show="modals.status_cuseta" class="list-container">
                        <input ref="status_cuseta" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="stat in status.cuseta"
                                :key="stat.id"
                                @click="$selectData(stat, 'status_cuseta')"
                                >{{ stat }}
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############  CUSETA ############## -->
                <div
                    v-show="selectedData.status_cuseta != ''"
                    class="input-list-container"
                >
                    <div class="input-container">
                        <input
                            v-model="newName.cuseta"
                            readonly
                            :inp="newName.cuseta"
                            type="text"
                            @click="$toggleModal('cuseta')"
                        />
                        <label for="cuseta">Cuseta</label>
                    </div>
                    <div v-show="modals.cuseta" class="list-container">
                        <input ref="cuseta" v-model="actions.filter" />
                        <div class="el-container">
                            <span
                                v-for="cuseta in $store.getters.filterAsset([
                                    'cuseta',
                                    actions.filter,
                                ])"
                                :key="cuseta.id"
                                @click="$selectData(cuseta.id, 'cuseta')"
                                >{{ cuseta.tag }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.user"
                        :inp="selectedData.user"
                        type="text"
                    />
                    <label for="user">User</label>
                </div>
                <div class="input-container">
                    <input
                        v-model="selectedData.tel_user"
                        :inp="selectedData.tel_user"
                        type="text"
                    />
                    <label for="tel_user">Telefon User</label>
                </div>
            </div>
            <div class="quill-container">
                <span class="delete icon" @click="$deleteData('obs', 'picking')"
                    ><font-awesome-icon icon="fa-solid fa-xmark"
                /></span>
                <quill-editor
                    ref="editor"
                    v-model="selectedData.obs"
                    class="ql-edit"
                />
            </div>
            <div class="h-bar">
                <button class="g-button" @click="$emit('edit-picking')">
                    Cancel
                </button>
                <button class="g-button" @click="postData()">
                    Edit Picking
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        editData: {
            type: Object,
            required: true,
        },
    },

    data: () => ({
        status: {
            device: ['STOC', 'SERVICE', 'CASAT', 'UZ'],
            sim: ['STOC', 'ACTIV', 'INACTIV'],
            cuseta: ['LIBER', 'UZ'],
        },
        propData: {},
        selectedData: {
            telefon: '',
            scaner: '',
            sim: '',
            depozit: '',
            cuseta: '',
            user: '',
            tel_user: '',
            obs: '',
            status_telefon: '',
            status_scaner: '',
            status_sim: '',
            status_cuseta: '',
        },
        modals: {
            telefon: false,
            scaner: false,
            sim: false,
            depozit: false,
            cuseta: false,
            status_telefon: false,
            status_scaner: false,
            status_sim: false,
            status_cuseta: false,
        },
        actions: {
            filter: '',
        },
        newName: {
            telefon: '',
            scaner: '',
            sim: '',
            depozit: '',
            cuseta: '',
        },
    }),

    async fetch() {
        const devices = ['telefon', 'sim', 'scaner', 'cuseta', 'depozit']
        for (let i = 0; i < devices.length; i++) {
            const element = await this.$axios.$get('picking/vuex/' + devices[i])
            this.$store.commit('set_picking', [devices[i], element])
        }
    },

    mounted() {
        this.propData = this.editData
        this.selectedData.obs = this.propData.obs
    },

    methods: {
        postData() {
            this.$axios
                .$post('picking/update/picking', {
                    id: this.editData.id,
                    id_telefon: this.selectedData.telefon,
                    id_scaner: this.selectedData.scaner,
                    id_sim: this.selectedData.sim,
                    id_depozit: this.selectedData.depozit,
                    id_cuseta: this.selectedData.cuseta,
                    user: this.selectedData.user,
                    tel_user: this.selectedData.tel_user,
                    obs: this.selectedData.obs,
                    status_telefon: this.selectedData.status_telefon,
                    status_scaner: this.selectedData.status_scaner,
                    status_sim: this.selectedData.status_sim,
                    status_cuseta: this.selectedData.status_cuseta,
                })
                .then((response) => {
                    this.$notification(response)
                })
                .then(this.$emit('edit-picking'))
        },
    },
}
</script>

<style lang="scss" scoped></style>

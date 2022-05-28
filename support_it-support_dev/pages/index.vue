<template>
    <div id="page">
        <div class="container-fluid page-title">
            <h1>Dashboard</h1>
        </div>
        <div class="container-fluid">
            <div class="row"></div>
            <!-- <quill-editor ref="editor" v-model="content" class="ql-editor" /> -->
            <!-- <vc-date-picker
                v-model="selectedData.data_trimis"
                :modelConfig="modelConfig"
            /> -->
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        selectedData: {
            data_trimis: '',
        },
        calendar: true,
        modelConfig: {
            type: 'string',
            mask: 'YYYY-MM-DD hh:mm:ss', // Uses 'iso' if missing
        },
        content: '',
    }),
    mounted() {},
    methods: {},
}
</script>

<style scoped lang="scss">
#page {
}
</style>

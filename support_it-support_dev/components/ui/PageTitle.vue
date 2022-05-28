<template>
    <div id="modal-title" class="container-fluid page-title">
        <h3 :style="'color:' + color + ';'">{{ title }}</h3>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true,
        },
        color: {
            type: String,
            required: false,
            default: 'black',
        },
    },
    data: () => ({}),
}
</script>

<style scoped>
#modal-title {
    margin: 0px;
    margin-bottom: 10px;
}
h3 {
    margin: 0px;
}
</style>

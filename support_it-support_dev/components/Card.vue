<template>
    <div class="container cardc">
        <div class="row">
            <p>
                {{ device + ' in stoc: ' }} <b>{{ data }}</b>
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        data: {
            type: Number,
            required: true,
        },
        device: {
            type: String,
            required: true,
        },
    },
}
</script>

<style>
.cardc {
    max-width: 380px;
    min-width: 250px;
    background-color: #29a745;
    border-radius: 5px;
    padding: 30px;
    margin: 5px 10px;
}
</style>

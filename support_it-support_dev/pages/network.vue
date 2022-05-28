<template>
    <div id="page">
        <RackList v-if="modals.rack" @rack-list="$toggleModal('rack')" />
        <div class="container-fluid page-title">
            <h1>Switch IMGB</h1>
        </div>
        <div class="container-fluid">
            <div id="building">
                <div class="dragger">
                    <img src="~/assets/images/switch-map.png" alt="" />
                    <span style="left: 16%; top: 20%" class="area-name"
                        >BATERII ETAJ 53</span
                    >
                    <span style="left: 28%; top: 21%" class="area-name"
                        >SCOALA DORIN</span
                    >
                    <span style="left: 56%; top: 5%" class="area-name"
                        >HALA TURBINE</span
                    >
                    <span style="left: 64%; top: 21%" class="area-name"
                        >LA POPA ETAJ 52</span
                    >
                    <span style="left: 8%; top: 23%" class="area-name"
                        >SERVER</span
                    >
                    <span
                        style="left: 15%; top: 26%"
                        class="area-code"
                        @click="modals.rack = true"
                        >R1</span
                    >
                    <span style="left: 33%; top: 26%" class="area-code"
                        >R2</span
                    >
                    <span style="left: 59%; top: 13%" class="area-code"
                        >R3</span
                    >
                    <span style="left: 65%; top: 26%" class="area-code"
                        >R4</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RackList from '~/components/networkmodals/RackList.vue'

export default {
    components: {
        RackList,
    },
    data: () => ({
        modals: {
            rack: false,
        },
    }),
    mounted() {
        const slider = document.querySelector('#building')
        let isDown = false
        let startX
        let startY
        let scrollLeft
        let scrollTop

        slider.addEventListener('mousedown', (e) => {
            isDown = true
            slider.classList.add('active')
            startX = e.pageX - slider.offsetLeft
            startY = e.pageY - slider.offsetTop
            scrollLeft = slider.scrollLeft
            scrollTop = slider.scrollTop
        })
        slider.addEventListener('mouseleave', () => {
            isDown = false
            slider.classList.remove('active')
        })
        slider.addEventListener('mouseup', () => {
            isDown = false
            slider.classList.remove('active')
        })
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return
            e.preventDefault()
            const x = e.pageX - slider.offsetLeft
            const walk = (x - startX) * 1 // scroll-fast
            slider.scrollLeft = scrollLeft - walk

            const y = e.pageY - slider.offsetLeft
            const walkY = (y - startY) * 1 // scroll-fast
            slider.scrollTop = scrollTop - walkY
        })
    },
    methods: {},
}
</script>

<style lang="scss" scoped>
#page {
    background-color: white;
}
.page-title {
    color: black;
}
#building {
    width: 100%;
    height: 100%;
    overflow: auto;
    position: relative;
}

#building img {
    width: 100%;
}

.dragger {
    position: relative;
    width: 2000px;
}

.area-name {
    position: absolute;
    font-size: 18px;
    font-family: 'Trebuchet MS';
    background-color: #ffc107;
    display: flex;
    padding: 0 20px;
    line-height: 30px;
    border: 2px solid #000;
    color: black;
}

.area-code {
    position: absolute;
    left: 30%;
    top: 30%;
    font-size: 18px;
    font-family: 'Trebuchet MS';
    font-weight: 600;
    color: #8bc34a;
    display: flex;
    padding: 10px;
    border: 3px solid #000;
    cursor: pointer;
}
</style>

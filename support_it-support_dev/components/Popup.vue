<template>
    <div class="pop-container">
        <div v-for="note in notification" :key="note.id" class="note">
            <div class="bar" :class="{ red: note.error, green: !note.error }">
                <div class="type-container">
                    <span class="type-icon">
                        <font-awesome-icon
                            v-if="!note.error"
                            icon="fa-solid fa-circle-check"
                            class="green-icon"
                        />
                        <font-awesome-icon
                            v-if="note.error"
                            icon="fa-solid fa-circle-exclamation"
                            class="red-icon"
                        />
                    </span>
                    <div class="message">
                        <span v-if="!note.error">Succes!</span>
                        <span v-if="note.error">Eroare</span>
                        <span>{{ note.message }}</span>
                    </div>
                    <span class="x" @click="clearNote()">
                        <font-awesome-icon icon="fa-solid fa-xmark" />
                    </span>
                </div>
                <div
                    class="timer"
                    :class="{ timerErr: note.error, timerSuc: !note.error }"
                ></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        notification() {
            return this.$store.state.ui.info
        },
    },
    methods: {
        clearNote() {
            this.$store.commit('set_ui', ['info', []])
        },
    },
}
</script>

<style lang="scss" scoped>
$succes: #47d664;
$error: #e94f2d;
$info: #3186eb;

@mixin icon($color) {
    font-size: 20px;
    color: $color;
}
@mixin background($color) {
    background-color: $color;
}

.note {
    position: fixed;
    top: 5px;
    right: 10px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
}
.bar {
    position: relative;
    width: 100%;
    min-width: 200px;
    max-width: 600px;
    background-color: white;
    padding: 10px;
    border-radius: 2px;
    overflow: hidden;
}
.type-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    .type-icon {
        font-size: 20px;
        margin-right: 15px;
    }
    .x {
        margin-left: 20px;
        color: #a6a6a6;
    }
}
.message {
    display: flex;
    flex-direction: column;
    span:first-child {
        font-size: 20px;
    }
}
.green-icon {
    @include icon($succes);
}
.red-icon {
    @include icon($error);
}
.timer {
    position: absolute;
    width: 100%;
    height: 3px;
    background-color: #47d664;
    left: 0;
    bottom: 0;
    animation: slide 5s;
    transition: linear;
}
.timerErr {
    @include background($error);
}
.timerSuc {
    @include background($succes);
}
@keyframes slide {
    from {
        transform: translate(0px, 0px);
    }
    to {
        transform: translate(-100%, 0px);
    }
}
</style>

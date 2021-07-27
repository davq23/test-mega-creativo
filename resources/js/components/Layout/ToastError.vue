<template>
    <div class="toast align-items-center bg-danger" ref="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <ul>
                    <li v-for="(message, index) in messages" :key="index">
                        {{message}}
                    </li>
                </ul>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</template>

<script>
    import eventBus from './../../eventBus';

    export default {
        data() {
            return {
                messages: [],
            }
        },

        setup() {
            const toast = ref(null);


            return {toast};
        },

        created() {
            eventBus.$on('messages', messages => {
                this.messages = messages;
            });
        },

        mounted() {
            this.$refs.toast.addEventListener('hide.bs.toast', () => {
                this.messages = [];
            });
        }
    }

</script>

<style>

</style>

<template>
    <div class="modal fade" id="majorTableModal"
        tabindex="-1" aria-labelledby="majorTableModalLabel" ref="modal" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="majorTableModalLabel">Carreras</h5>
                    <button type="button" class="btn-close" :disabled="disabled"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <major-table />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MajorTable from './MajorTable.vue';


    export default {
        components: {
            MajorTable,
        },

        setup() {
            const modal = ref(null);

            return {modal};
        },

        mounted() {
        },

        data() {
            return {
                disabled: false,
            }
        },

        methods: {

        },
    }

</script>

<style>

</style>

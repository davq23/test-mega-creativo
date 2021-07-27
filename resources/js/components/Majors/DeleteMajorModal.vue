<template>
    <div class="modal" id="deleteMajorModal" tabindex="-1" ref="modal"
        aria-labelledby="deleteMajorModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMajorModal">
                        Eliminar carrera "{{majorName}}"
                    </h5>
                    <button type="button" class="btn-close" :disabled="disabled"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" :disabled="disabled"
                        data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger"
                        @click="handleClick"
                        :disabled="disabled">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import eventBus from './../../eventBus';

    export default {
        setup() {
            const modal = ref(null);

            return {
                modal,
            }
        },

        mounted() {
            this.$refs.modal.addEventListener('show.bs.modal', event => {
                const id = event.relatedTarget.getAttribute('data-bs-src');
                const index = event.relatedTarget.getAttribute('data-bs-idx');
                const majorName = event.relatedTarget.getAttribute('data-bs-major-name');

                if (!id || !index || !majorName) return;

                this.id = id;
                this.index = index;
                this.majorName = majorName;


            });

            this.$refs.modal.addEventListener('hide.bs.modal', event => {
            });
        },

        data() {
            return {
                id: Number,
                index: Number,
                majorName: '',
                disabled: false,
            }
        },

        methods: {
            handleClick() {
                this.disabled = true;

                axios.delete(`api/majors/delete/${this.id}`)
                    .then(response => {
                        if (response.status === 200) {
                            this.$el.querySelector('button.btn-close').dispatchEvent(new Event('click'));

                            eventBus.$emit('delete-major', {
                                id: this.id,
                                index: this.index
                            });

                        }
                    })
                    .catch(error => {

                    })
                    .finally(() => {
                        this.disabled = false;
                    })
            }

        }
    }

</script>

<style>

</style>

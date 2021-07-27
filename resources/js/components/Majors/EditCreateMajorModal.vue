<template>
    <div class="modal fade" id="editCreateMajorModal"
        tabindex="-1" aria-labelledby="editCreateMajorModalLabel" ref="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form @submit="handleSubmit">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCreateMajorModalLabel">Carrera Info</h5>
                    <button type="button" class="btn-close" :disabled="disabled"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label for="major-name" class="form-label">Nombre</label>
                            <input type="text" name="major-name" class="form-control"
                                v-model="major.name" :disabled="disabled">
                        </div>

                        <div class="form-group">
                            <label for="major-description" class="form-label">Descripción</label>
                            <textarea type="text" name="major-description" class="form-control"
                                v-model="major.description" :disabled="disabled">
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="major-status" class="form-label">Acciones</label>
                            <select name="major-status" class="form-select"
                                v-model="major.status"
                                :disabled="disabled">
                                <option value="1">Activa</option>
                                <option value="0">Inactiva</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" :disabled="disabled" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" :disabled="disabled" v-if="major.id">
                        Editar
                    </button>
                    <button type="submit" class="btn btn-primary" :disabled="disabled" v-else>
                        Crear
                    </button>
                </div>
            </form>
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

            return {modal};
        },

        created() {
            eventBus.$on("select-major", majorInfo => {
                this.disabled = true;
                this.index = majorInfo.index;

                axios.get(`api/majors/${majorInfo.id}`)
                    .then(response => {
                        if (response.status === 200) {
                            this.major = response.data;
                        }
                    })
                    .catch(error => {

                    })
                    .finally(() => {
                        this.disabled = false;
                    });
            });
        },

        mounted() {
            this.$refs.modal.addEventListener('hide.bs.modal', (event) => {
                this.major = {};
            });
        },

        data() {
            return {
                major: {},
                disabled: false,
                index: null,
            }
        },

        methods: {
            handleSubmit(event) {
                event.preventDefault();
                let request = null;

                if (this.major.id) {
                    this.disabled = true;

                    request = axios.put(`api/majors/edit/${this.major.id}`, this.major)
                        .then(response => {
                            if (response.status === 200) {
                                eventBus.$emit('edit-major', {...response.data, index: this.index});

                                this.$el.querySelector('button.btn-close').dispatchEvent(new Event('click'));
                            }
                        })
                        .catch(error => {

                        })

                } else {
                    request = axios.post(`api/majors/new`, this.major,
                        {
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.status === 201) {
                                this.$el.querySelector('button.btn-close').dispatchEvent(new Event('click'));
                            }
                        })
                        .catch(error => {

                        });
                }

                request.finally(() => {
                    this.disabled = false;
                })
            }
        },
    }

</script>

<style>

</style>

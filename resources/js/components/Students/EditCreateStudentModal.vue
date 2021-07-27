<template>
    <div class="modal fade" id="editCreateStudentModal" tabindex="-1" aria-labelledby="editCreateStudentModalLabel"
        ref="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form @submit="handleSubmit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCreateStudentModalLabel">Student Info</h5>
                        <button type="button" class="btn-close" :disabled="disabled" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="student-name" class="form-label">Nombre</label>
                            <input type="text" name="student-name" class="form-control" v-model="student.name"
                                :disabled="disabled">
                        </div>

                        <div class="form-group">
                            <label for="student-last_names" class="form-label">Apellidos</label>
                            <input type="text" name="student-last_names" class="form-control"
                                v-model="student.last_names" :disabled="disabled" />
                        </div>
                        <div class="form-group">
                            <label for="student-email" class="form-label">Email</label>
                            <input type="email" name="student-email" class="form-control" v-model="student.email"
                                :disabled="disabled" />
                        </div>
                        <div class="form-group">
                            <label for="student-email" class="form-label">Carrera</label>
                            <div class="dropdown">
                                <input type="hidden" name="student-major-id" v-model="student.major_id">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{major.name ? major.name : 'Busque una carrera...'}}
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="text-center">
                                        <input type="text" autocomplete="off" v-model="majorSearch" @input="handleInput"
                                            name="major-search" class="form-control" />
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li v-for="(majorResult, index) in majorResults" :key="index">
                                        <a href="#" class="dropdown-item"
                                            @click="handleClick(majorResult)">{{majorResult.name}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="student-status" class="form-label">Estatus</label>
                            <select name="student-status" class="form-select" v-model="student.status"
                                :disabled="disabled">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" :disabled="disabled"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" :disabled="disabled" v-if="student.id">
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

        data() {
            return {
                disabled: false,
                student: {},
                major: {},
                majorResults: [],
                majorSearch: '',
                searchTimeout: null,
                index: null,
            }
        },

        created() {
            eventBus.$on("select-student", studentInfo => {
                this.disabled = true;

                this.index = studentInfo.index;

                axios.get(`api/students/${studentInfo.id}`)
                    .then(response => {
                        if (response.status === 200) {
                            this.student = response.data;

                            this.major = {
                                id: studentInfo.major.id,
                                name: studentInfo.major.name
                            }
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
                this.student = {};
                this.disabled = false;
                this.major = {};
                this.majorResults = [];
                this.majorSearch = '';
            });
        },

        methods: {
            handleClick(major) {
                this.major = major;
                this.student.major_id = major.id;
            },

            handleInput(event) {
                if (this.searchTimeout) clearTimeout(this.searchTimeout);

                this.searchTimeout = setTimeout(() => {
                    axios.post('api/majors/search/25', {
                        'major_search': this.majorSearch
                    })
                    .then(response => {
                        if (response.status === 200) {
                            this.majorResults = response.data.majors;
                        }
                    })
                    .then(error => {

                    });
                }, 300);
            },

            handleSubmit(event) {
                event.preventDefault();
                let request = null;

                this.disabled = true;

                if (this.student.id) {

                    const major_name = this.major.name;

                    request = axios.put(`api/students/edit/${this.student.id}`, this.student)
                        .then(response => {
                            if (response.status === 200) {
                                eventBus.$emit('edit-student', {...response.data,
                                    major_name: major_name, index: this.index});

                                this.$el.querySelector('button.btn-close').dispatchEvent(new Event('click'));
                            }
                        })
                        .catch(error => {

                        })

                } else {
                    request = axios.post(`api/students/new`, this.student,
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

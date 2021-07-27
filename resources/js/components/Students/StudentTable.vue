<template>
    <table class="table table-striped">
        <tr class="text-center">
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Carrera</th>
            <th>Estatus</th>
        </tr>
        <tbody>
            <student-table-row v-for="(student, index) in students"
            :student="student" :index="Number(index)" :key="index" />
        </tbody>
        <tfoot>
            <tr class="text-center">
                <td colspan="2">
                    <button :class="disabled || !last ? 'btn btn-secondary' : 'btn btn-primary'"
                    @click="loadStudents('back')">
                        Last
                    </button>
                </td>
                <td colspan="2">
                    <button :class="disabled || !next ? 'btn btn-secondary' : 'btn btn-primary'"
                    @click="loadStudents('next')">
                        Next
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
    import axios from 'axios';
    import StudentTableRow from './StudentTableRow.vue';
    import eventBus from './../../eventBus';

    export default {
        components: {
            StudentTableRow,
        },

        created() {
            eventBus.$on('edit-major', major => {
                this.students.forEach(student => {
                    if (student.major_id === major.id) {
                        student.major_name = major.name
                    }
                });
            });

            eventBus.$on('edit-student', student => {
                if (this.students[student.index].id == student.id) {
                    this.$set(this.students, student.index, student);
                }
            });

            eventBus.$on('delete-student', student => {
                if (this.students[student.index].id == student.id) {
                    this.$delete(this.students, student.index);
                }
            });
        },

        data() {
            return {
                students: [],
                next: 0,
                limit: 25,
                last: null,
                disabled: false,
            };
        },

        mounted() {
            this.loadStudents('next');
        },

        methods: {
            loadStudents(direction) {
                const offset = direction === 'next' ? this.next : this.last;

                if (offset === null) return;

                this.disabled = true;

                axios.get(`api/students/all/${this.limit}/${offset}/${direction}`)
                    .then(response => {
                        if (response.status === 200) {
                            this.students = response.data.students;
                            this.next = response.data.next_student_id;
                            this.last = response.data.last_student_id;
                        }
                    })
                    .catch(error => {

                    })
                    .finally(() => {
                        this.disabled = false;
                    })
            },
        }
    }

</script>

<style>

</style>

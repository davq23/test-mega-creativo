<template>
    <tr>
        <td>{{student.name}}</td>
        <td>{{student.last_names}}</td>
        <td>
            <a :data-bs-src="student.major_id"
                href="#"
                data-bs-toggle="modal"
                data-bs-target="#editCreateMajorModal"
                @click="selectCourse">{{student.major_name}}</a>
        </td>
        <td class="text-center">
            <button class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#editCreateStudentModal"
                @click="selectStudent">
                Details
            </button>
            <button class="btn btn-danger" data-bs-toggle="modal"
                :data-bs-src="student.id"
                :data-bs-idx="index"
                :data-bs-complete-name="`${student.name} ${student.last_names}`"
                data-bs-target="#deleteStudentModal"
                @click="selectStudent">
                Delete
            </button>
        </td>
    </tr>
</template>

<script>
    import eventBus from './../../eventBus';

    export default {
        props: {
            student: Object,
            index: Number,
        },

        data() {
            return {}
        },

        methods: {
            selectCourse() {
                eventBus.$emit('select-major', {
                    id: this.student.major_id,
                    index: this.index,
                });
            },

            selectStudent() {
                eventBus.$emit('select-student', {
                    id: this.student.id,
                    major: {
                        id: this.student.major_id,
                        name: this.student.major_name,
                    },
                    index: this.index,
                });
            },

        }
    }

</script>

<style>


</style>

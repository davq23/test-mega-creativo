<template>
    <tr>
        <td>{{major.name}}</td>
        <td>{{major.status == 1 ? 'Activa' : 'Inactiva'}}</td>
        <td class="text-center">
            <button class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#editCreateMajorModal"
                @click="selectMajor">
                Details
            </button>
            <button class="btn btn-danger" data-bs-toggle="modal"
                :data-bs-src="major.id"
                :data-bs-idx="index"
                :data-bs-major-name="`${major.name}}`"
                data-bs-target="#deleteMajorModal"
                @click="selectMajor">
                Delete
            </button>
        </td>
    </tr>
</template>

<script>
    import eventBus from '../../eventBus';

    export default {
        props: {
            major: Object,
            index: Number,
        },

        data() {
            return {}
        },

        methods: {
            selectMajor() {
                eventBus.$emit('select-major', {
                    id: this.major.id,
                    major: {
                        id: this.major.major_id,
                        name: this.major.major_name,
                    },
                    index: this.index,
                });
            },

        }
    }

</script>

<style>


</style>

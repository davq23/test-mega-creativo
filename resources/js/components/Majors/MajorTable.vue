<template>
    <table class="table table-striped">
        <tr class="text-center">
            <th>Nombre</th>
            <th>Estatus</th>
            <th>Acciones</th>
        </tr>
        <tbody>
            <major-table-row v-for="(major, index) in majors"
            :major="major" :index="Number(index)" :key="index" />
        </tbody>
        <tfoot>
            <tr class="text-center">
                <td colspan="2">
                    <button :class="disabled || !last ? 'btn btn-secondary' : 'btn btn-primary'"
                    @click="loadMajors('back')">
                        Last
                    </button>
                </td>
                <td colspan="2">
                    <button :class="disabled || !next ? 'btn btn-secondary' : 'btn btn-primary'"
                    @click="loadMajors('next')">
                        Next
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
    import axios from 'axios';
    import MajorTableRow from './MajorTableRow.vue';
    import eventBus from './../../eventBus';

    export default {
        components: {
            MajorTableRow,
        },

        created() {
            eventBus.$on('edit-major', major => {
                if (this.majors[major.index].id == major.id) {
                    this.$set(this.majors, major.index, major);
                }
            });

            eventBus.$on('delete-major', major => {
                if (this.majors[major.index].id == major.id) {
                    this.$delete(this.majors, major.index);
                }
            });
        },

        data() {
            return {
                majors: [],
                next: 0,
                limit: 25,
                last: null,
                disabled: false,
            };
        },

        mounted() {
            this.loadMajors('next');
        },

        methods: {
            loadMajors(direction) {
                const offset = direction === 'next' ? this.next : this.last;

                if (offset === null) return;

                this.disabled = true;

                axios.get(`api/majors/all/${this.limit}/${offset}/${direction}`)
                    .then(response => {
                        if (response.status === 200) {
                            this.majors = response.data.majors;
                            this.next = response.data.next_major_id;
                            this.last = response.data.last_major_id;
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

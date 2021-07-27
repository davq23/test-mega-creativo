<template>
    <div>
        <navbar />
        <div class="container">
            <student-table />
            <delete-student-modal />
            <edit-create-student-modal />
            <delete-major-modal />
            <edit-create-major-modal />
        </div>
    </div>
</template>

<script>
import EditCreateStudentModal from './Students/EditCreateStudentModal.vue';
import DeleteStudentModal from './Students/DeleteStudentModal.vue';
import EditCreateMajorModal from './Majors/EditCreateMajorModal.vue';
import DeleteMajorModal from './Majors/DeleteMajorModal.vue';
import StudentTable from './Students/StudentTable.vue';
import Navbar from './Layout/Navbar.vue';

export default {
  components: { StudentTable,
    EditCreateStudentModal,
    DeleteStudentModal,
    EditCreateMajorModal,
    DeleteMajorModal,
    Navbar
    },

}
</script>

<style>

</style>

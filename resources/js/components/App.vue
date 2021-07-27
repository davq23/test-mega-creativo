<template>
    <div>
        <navbar />
        <div class="container">
            <student-table />
            <delete-student-modal />
            <edit-create-student-modal />
            <major-table-modal />
            <edit-create-major-modal />
            <delete-major-modal />
        </div>
    </div>
</template>

<script>
import EditCreateStudentModal from './Students/EditCreateStudentModal.vue';
import DeleteStudentModal from './Students/DeleteStudentModal.vue';
import EditCreateMajorModal from './Majors/EditCreateMajorModal.vue';
import DeleteMajorModal from './Majors/DeleteMajorModal.vue';
import StudentTable from './Students/StudentTable.vue';
import MajorTableModal from './Majors/MajorTableModal.vue';
import Navbar from './Layout/Navbar.vue';

export default {
  components: { StudentTable,
    EditCreateStudentModal,
    DeleteStudentModal,
    EditCreateMajorModal,
    DeleteMajorModal,
    MajorTableModal,
    Navbar
    },

}
</script>

<style>

</style>

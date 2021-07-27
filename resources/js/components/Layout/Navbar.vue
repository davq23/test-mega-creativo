<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="#" data-bs-toggle="modal"
                        data-bs-target="#editCreateStudentModal">
                        Crear estudiante
                    </a>
                    <a class="nav-link active" aria-current="page" href="#" data-bs-toggle="modal"
                        data-bs-target="#editCreateMajorModal">
                        Crear carrera
                    </a>
                    <a class="nav-link active" aria-current="page" href="#" data-bs-toggle="modal"
                        data-bs-target="#majorTableModal">
                        Ver carreras
                    </a>
                    <a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal"
                        data-bs-target="#editCreateNajorModal"></a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {

    }

</script>

<style>

</style>

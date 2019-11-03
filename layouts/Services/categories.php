<?php

defined('_EXEC') or die;

$this->dependencies->getDependencies([
    'css' => [
        '{$path.plugins}DataTables/css/jquery.dataTables.min.css',
        '{$path.plugins}DataTables/css/dataTables.material.min.css',
        '{$path.plugins}DataTables/css/responsive.dataTables.min.css',
        '{$path.plugins}DataTables/css/buttons.dataTables.min.css'
    ],
    'js' => [
        '{$path.js}pages/services.js',
        '{$path.plugins}DataTables/js/jquery.dataTables.min.js',
        '{$path.plugins}DataTables/js/dataTables.material.min.js',
        '{$path.plugins}DataTables/js/dataTables.responsive.min.js',
        '{$path.plugins}DataTables/js/dataTables.buttons.min.js',
        '{$path.plugins}DataTables/js/pdfmake.min.js',
        '{$path.plugins}DataTables/js/vfs_fonts.js',
        '{$path.plugins}DataTables/js/buttons.html5.min.js'
    ],
    'other' => [

    ]
]);
?>

%{header}%

<main class="body">
    <div class="content">
        <div class="box-buttons">
            <a data-button-modal="deleteCategories"><i class="material-icons">delete</i><span>Eliminar</span></a>
            <a data-button-modal="categories"><i class="material-icons">add</i><span>Nuevo</span></a>
            <a href="/services"><i class="material-icons">arrow_back</i><span>Regresar</span></a>
            <div class="clear"></div>
        </div>
        <div class="table-responsive-vertical padding">
            <table id="tblCategories" class="display" data-page-length="100">
                <thead>
                    <tr>
                        <th width="20px"></th>
                        <th>Categoría</th>
                        <th width="35px"></th>
                    </tr>
                </thead>
                <tbody>
                    {$lstCategories}
                </tbody>
            </table>
        </div>
    </div>
</main>

<section class="modal" data-modal="categories">
    <div class="content">
        <header>
            <h6>Nueva categoría</h6>
        </header>
        <main>
            <form name="categories" data-submit-action="new">
                <fieldset class="input-group">
                    <label data-important>
                        <span>Nombre</span>
                        <input type="text" name="name" autofocus>
                    </label>
                </fieldset>
            </form>
        </main>
        <footer>
            <a button-cancel>Cancelar</a>
            <a button-success>Aceptar</a>
        </footer>
    </div>
</section>

<section class="modal alert" data-modal="deleteCategories">
    <div class="content">
        <header>
            <h6>Alerta</h6>
        </header>
        <main>
            <p>¿Esta seguro que desea eliminar esta selección de categorías?</p>
        </main>
        <footer>
            <a button-close>Cancelar</a>
            <a data-action="deleteCategories">Aceptar</a>
        </footer>
    </div>
</section>

<div x-data="yTable()">

    <div class="alert alert-danger" x-text="error" x-show="error!==''"></div>
    <div class="alert alert-success" x-show="success">Die Tabelle wurde angelegt.</div>

    <div class="row">
        <div class="col-md-4">
            <label class="control-label" for="table-name"><?= rex_i18n::msg('yform_seeder_table_name') ?></label>
            <input class="form-control" type="text" id="table-name" x-model="tableName">
        </div>
        <div class="col-md-4">
            <label class="control-label" for="table-label"><?= rex_i18n::msg('yform_seeder_table_label') ?></label>
            <input class="form-control" type="text" id="table-label" x-model="tableLabel">
        </div>
        <div class="col-md-2">
            <label class="control-label" for="per-page"><?= rex_i18n::msg('yform_seeder_per_page') ?></label>
            <input class="form-control" type="number" id="per-page" x-model="perPage">
        </div>
        <div class="col-md-2 text-center">
            <label class="control-label" for="active"><?= rex_i18n::msg('yform_seeder_active') ?></label>
            <input class="form-control" type="checkbox" id="active" x-model="active">
        </div>
    </div>

    <hr>

    <?php
    /**
     * value selection.
     */
    $fragment = new rex_fragment();
    echo $fragment->parse('yform_seeder/fields.php');
    ?>

    <div class="row">
        <div class="col-md-4">
            <?php
            /**
             * value selection.
             */
            $fragment = new rex_fragment();
            echo $fragment->parse('yform_seeder/value-select.php');
            ?>
        </div>
        <div class="col-md-4">
            <?php
            /**
             * value selection.
             */
            $fragment = new rex_fragment();
            echo $fragment->parse('yform_seeder/validation-select.php');
            ?>
        </div>
    </div>

    <hr>

    <?php
    /**
     * buttons.
     */
    $fragment = new rex_fragment();
    echo $fragment->parse('yform_seeder/create-button.php');
    ?>
</div>

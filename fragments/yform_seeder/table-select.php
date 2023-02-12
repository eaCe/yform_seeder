<?php
/**
 * @var rex_fragment $this
 */

$tablesArray = \YformSeeder\GUI::getTablesArray();
?>
<form method="get"
      :action="rex.yform_seeder_url"
      x-target="field-select"
      @ajax:before="showLoader()"
      @ajax:success="showFields($event)"
      @ajax:after="hideLoader()"
      x-ajax>
    <label for="table-select">
        <?= rex_i18n::msg('formbuilder_table_select') ?>
    </label>
    <select name="table"
            id="table-select"
            class="form-control"
            x-ref="tableSelect"
            @change="$el.form.requestSubmit()">
        <option value="" disabled></option>
        <?php
        foreach ($tablesArray as $tableArray) {
            $table = rex_yform_manager_table::get($tableArray['table_name']);
            echo '<option value="' . $table->getTableName() . '">' . $table->getName() . '</option>';
        }
        ?>
    </select>
    <input type="hidden" name="get_table" value="1">
</form>

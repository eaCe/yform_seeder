<?php
/**
 * @var rex_fragment $this
 */
?>
<form>
    <label for="table-select">
        <?= rex_i18n::msg('yform_seeder_value_select') ?>
    </label>
    <select class="form-control"
            x-ref="value"
            @change="addValue($el.value)">
        <option value="" disabled></option>
        <?php foreach (\YformSeeder\GUI::getValuesArray() as $value) : ?>
            <option value="<?= $value['name'] ?>">
                <?= $value['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

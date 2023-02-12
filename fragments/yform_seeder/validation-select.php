<?php
/**
 * @var rex_fragment $this
 */
?>
<form>
    <label for="table-select">
        <?= rex_i18n::msg('yform_seeder_validation_select') ?>
    </label>
    <select class="form-control"
            x-ref="validation"
            @change="addValidation($el.value)">
        <option value="" disabled></option>
        <?php foreach (\YformSeeder\GUI::getValidatesArray() as $validation) : ?>
            <option value="<?= $validation['name'] ?>">
                <?= $validation['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

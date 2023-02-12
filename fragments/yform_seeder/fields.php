<?php
/**
 * @var rex_fragment $this
 */
?>

<template x-for="(field, index) in fields" :key="field.uid">
    <div class="row flex flex-wrap items-end mb-4" x-init="console.log(field)">
        <div class="px-[15px] flex-1">
            <label :for="'field_name_'+index">
                <?= rex_i18n::msg('yform_seeder_type') ?> <span class="font-normal" x-show="field.type">[<span x-text="field.type"></span>]</span>
            </label>
            <input class="form-control"
                   readonly
                   type="text"
                   :id="'field_name_'+index"
                   x-model="field.field_name">
        </div>
        <div class="px-[15px] flex-1">
            <label :for="'name_'+index"><?= rex_i18n::msg('yform_seeder_name') ?></label>
            <input class="form-control"
                   type="text"
                   :id="'name_'+index"
                   x-model="field.name">
        </div>
        <div class="px-[15px] flex-1">
            <label :for="'label_'+index"><?= rex_i18n::msg('yform_seeder_label') ?></label>
            <input
                class="form-control"
                type="text"
                :id="'label_'+index"
                x-model="field.label">
        </div>
        <div class="px-[15px] flex-auto flex-grow-0">
            <label :for="'list_hidden_'+index"><?= rex_i18n::msg('yform_seeder_list_hidden') ?></label>
            <input class="form-control"
                   type="checkbox"
                   :id="'list_hidden_'+index"
                   x-model="field.list_hidden">
        </div>
        <div class="px-[15px] flex-auto flex-grow-0">
            <button
                class="btn btn-danger"
                @click.prevent="deleteField(index)">
                <i class="rex-icon fa-trash"></i>
            </button>
        </div>
    </div>
</template>

<template x-if="fields.length">
    <hr>
</template>

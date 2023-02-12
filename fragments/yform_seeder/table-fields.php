<?php
/**
 * @var rex_fragment $this
 */
?>

<template x-for="(column, index) in columns">
    <div class="row flex flex-wrap items-end mb-4">
        <div class="px-[15px] flex-1">
            <label :for="column.name + '_' + index" x-text="column.name"></label>
            [<span x-text="column.type"></span>]
            <input class="form-control"
                   type="text"
                   :type="getType(column.type)"
                   :name="column.name"
                   :id="column.name + '_' + index">
        </div>
    </div>
</template>

<template x-if="columns.length">
    <hr>
</template>

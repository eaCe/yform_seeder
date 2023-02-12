<?php
/**
 * @var rex_fragment $this
 */
?>

<div class="row">
    <div class="col-md-12">
        <form
            method="post"
            x-ajax
            @ajax:before="showLoader()"
            @ajax:after="hideLoader()"
            @ajax:success="showSuccess()"
            @ajax:error="showError($event)"
            :action="rex.yform_seeder_url">
            <button
                class="btn btn-success"
                type="submit">
                Create Table
            </button>

            <input type="hidden" name="create" value="true">
            <input type="hidden" name="table_name" :value="tableName">
            <input type="hidden" name="table_label" :value="tableLabel">
            <input type="hidden" name="per_page" :value="perPage">
            <input type="hidden" name="active" :value="active">
            <input type="hidden" name="fields" :value="JSON.stringify(fields)">
        </form>
    </div>
</div>




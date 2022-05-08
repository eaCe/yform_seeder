<?php
/** @var \rex_addon $this */

rex_sql_table::get(rex::getTable($this->getName()))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('file', 'text', true))
    ->ensure();

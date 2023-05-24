<?php

/** @var \rex_addon $this */

rex_sql_table::get(rex::getTable($this->getName()))->drop();

<?php
/** @var \rex_addon $this */

rex_sql_table::get($this->getName())->drop();
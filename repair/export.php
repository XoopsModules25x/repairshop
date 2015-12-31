<?php

// this page uses smarty template
// this must be set before including main header.php
$xoopsOption['template_main'] = 'list_garage.html';

include_once "header.php";
include "include/fonctions.php";

export();
		
include_once "footer.php";
?>
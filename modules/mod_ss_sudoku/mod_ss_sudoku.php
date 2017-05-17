<?php
// No direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$hello = ModSSSudokuHelper::getHello();

require JModuleHelper::getLayoutPath('mod_ss_sudoku');
<?php
// No direct access
defined('_JEXEC') or die;

// Include the feed functions only once
JLoader::register('ModSSSudokuHelper', __DIR__ . '/helper.php');

$hello = ModSSSudokuHelper::getHello();

require JModuleHelper::getLayoutPath('mod_ss_sudoku');

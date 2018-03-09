<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.soleil
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app = JFactory::getApplication();
$user = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Deactive meta generator joomla
$this->setGenerator(null);

// Detecting Active Variables
$option = $app->input->getCmd('option', '');
$view = $app->input->getCmd('view', '');
$layout = $app->input->getCmd('layout', '');
$task = $app->input->getCmd('task', '');
$itemid = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

// Add template js
JHtml::_('script', 'js/soleil.js', array('version' => 'auto', 'relative' => true));

// Add template stylesheets
JHtml::_('stylesheet', 'css/soleil.css', array('version' => 'auto', 'relative' => true));

// Code Highlight
if ($this->params->get('codeHighlight')) {
    JHtml::_('stylesheet', 'node_modules/highlightjs/styles/xcode.css', array('version' => 'auto', 'relative' => true));
    JHtml::_('script', 'node_modules/highlightjs/highlight.pack.min.js', array('version' => 'auto', 'relative' => true));
    $this->addScriptDeclaration('jQuery(document).ready(function(){if(hljs){hljs.initHighlightingOnLoad();}});');
}

// Logo image
if ($this->params->get('logoFile')) {
    $logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <jdoc:include type="head"/>
  <link rel="apple-touch-icon" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/apple-touch-icon.png">
</head>

<body class="site <?php echo $option
    . ' view-' . $view
    . ($layout ? ' layout-' . $layout : ' no-layout')
    . ($task ? ' task-' . $task : ' no-task')
    . ($itemid ? ' itemid-' . $itemid : '')
    . ($this->direction == 'rtl' ? ' rtl' : '');
?>">
<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
  <div class="row">
    <!-- Header -->
    <header class="header col-3" role="banner">
        <?php if (isset($logo)) : ?>
          <a href="<?php echo $this->baseurl; ?>/"><?php echo $logo; ?></a>
        <?php endif; ?>

        <?php if ($this->params->get('sitetitle')) : ?>
            <?php echo '<h1 class="site-title" title="' . $sitename . '"><a href="' . JURI::base() . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</a></h1>'; ?>
        <?php endif; ?>

        <?php if ($this->params->get('sitedescription')) : ?>
            <?php echo '<h2 class="site-description">' . htmlspecialchars($this->params->get('sitedescription')) . '</h2>'; ?>
        <?php endif; ?>

      <div class="searchsite">
        <jdoc:include type="modules" name="search" style="none"/>
      </div>

      <div class="sidemenu">
        <jdoc:include type="modules" name="menu" style="none"/>
      </div>

      <!-- Footer -->
      <footer class="footer" role="contentinfo">
        <jdoc:include type="modules" name="footer" style="none"/>
      </footer>
    </header>

    <!-- Content -->
    <div class="content col-9">
      <div class="row">
        <main role="main" class="main col-8">
          <!-- Begin Content -->
          <jdoc:include type="message"/>
          <jdoc:include type="component"/>
          <!-- End Content -->
        </main>

        <div class="sidebar col-4">
            <?php if ($this->countModules('mostreadarticle')) : ?>
              <section class="mostreadarticle">
                <h2 class="site-title">Most Read</h2>
                <jdoc:include type="modules" name="mostreadarticle" style="none"/>
              </section>
            <?php endif; ?>

            <?php if ($this->countModules('lastestarticle')) : ?>
              <section class="lastestarticle">
                <h2 class="site-title">Lastest Article</h2>
                <jdoc:include type="modules" name="lastestarticle" style="none"/>
              </section>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<?php
defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Deactive meta generator joomla
$this->setGenerator(null);

// Detecting Active Variables
$option = $app->input->getCmd('option', '');
$view = $app->input->getCmd('view', '');
$layout = $app->input->getCmd('layout', '');
$task = $app->input->getCmd('task', '');
$itemid = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

// Framework
//JHtml::_('bootstrap.loadCss', true, $this->direction);
JHtml::_('bootstrap.framework');

// Stylesheet
$doc->addStyleSheet('templates/' . $this->template . '/css/bootstrap.min.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/bootstrap-responsive.min.css');
$doc->addStyleSheet('media/jui/css/bootstrap-extended.css');
$doc->addStyleSheet('media/jui/css/icomoon.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/font.min.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/soleil.min.css');

// JavaScript
$doc->addScript('templates/' . $this->template . '/js/soleil.min.js');

// Code Highlight
if ($this->params->get('codeHighlight')) {
	$doc->addStyleSheet('templates/' . $this->template . '/js/highlightjs/monokai-sublime.css');
	$doc->addScript('templates/' . $this->template . '/js/highlightjs/highlight.pack.js');
	$doc->addScriptDeclaration('jQuery(document).ready(function(){if(hljs){hljs.initHighlightingOnLoad();}});');
}

// Logo image
if ($this->params->get('logoFile')) {
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}

// Google font
if ($this->params->get('googleFontHeader')) {
	$doc->addStyleSheet('//fonts.googleapis.com/css?family=' . $this->params->get('googleFontNameHeader'));
}
if ($this->params->get('googleFontContent')) {
	$doc->addStyleSheet('//fonts.googleapis.com/css?family=' . $this->params->get('googleFontNameContent'));
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>"
      lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<jdoc:include type="head"/>
	<link rel="apple-touch-icon" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/apple-touch-icon.png">

	<?php if ($this->params->get('googleFontHeader')) : ?>
		<style type="text/css">
			.site-title, .site-description {
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontNameHeader')); ?>', Helvetica,Arial,sans-serif;
			}
		</style>
	<?php endif; ?>

    <?php if ($this->params->get('googleFontContent')) : ?>
		<style type="text/css">
			body {
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontNameContent')); ?>', Helvetica,Arial,sans-serif;
			}
		</style>
	<?php endif; ?>
</head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($this->direction == 'rtl' ? ' rtl' : '');
?>">
<div class="container-fluid">
	<div class="row-fluid">
		<!-- Header -->
		<header class="header span3" role="banner">
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
		<div class="content span9">
			<div class="row-fluid">
				<main role="main" class="main span8">
					<!-- Begin Content -->
					<jdoc:include type="message"/>
					<jdoc:include type="component"/>
					<!-- End Content -->
				</main>

				<div class="sidebar span4">
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

					<?php if ($this->params->get('googleAdSense')) : ?>
						<section>
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<!-- First ad -->
							<ins class="adsbygoogle"
								 style="display:block"
								 data-ad-client="ca-pub-4209198078307665"
								 data-ad-slot="1660972833"
								 data-ad-format="auto"></ins>
							<script>
								(adsbygoogle = window.adsbygoogle || []).push({
                                    google_ad_client: "ca-pub-4209198078307665",
                                    enable_page_level_ads: jQuery(window).width() < 768
                                });
							</script>
						</section>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if ($this->params->get('googleAnalytics')) : ?>
	<script>
		(function (i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function () {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-79686438-1', 'auto');
		ga('send', 'pageview');

	</script>
<?php endif; ?>

</body>
</html>

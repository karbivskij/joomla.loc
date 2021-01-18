<?php
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$app  = JFactory::getApplication();
$menu = $app->getMenu()->getActive();
$user = JFactory::getUser();
$this->setHtml5(true);
$this->setGenerator(null);

/*
unset($doc->_scripts[$this->baseurl . '/media/jui/js/bootstrap.min.js']);
unset($doc->_scripts[$this->baseurl . '/media/jui/js/jquery.min.js']);
unset($doc->_scripts[$this->baseurl . '/media/jui/js/jquery-noconflict.js']);
unset($doc->_scripts[$this->baseurl . '/media/jui/js/jquery-migrate.min.js']);
*/
//htmlspecialchars($this->params->get('sitedescription'), ENT_COMPAT, 'UTF-8')

$params = $app->getTemplate(true)->params;
// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');

if (("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) == (JURI::root()) ||  ("http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) == (JURI::root())) {
	$page = "home";
} else {
	$page = "page";
}


// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));
// Add Stylesheets
JHtml::_('stylesheet', 'slick.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'slick-theme.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'slick-theme.css', array('version' => 'auto', 'relative' => true));


/*
	
	

*/
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	
	
	<link rel="icon" href="/templates/<?php echo $this->template ?>/favicon.png">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" >
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<jdoc:include type="head" />
	
	<link rel="stylesheet" href="/templates/<?php echo $this->template ?>/css/style.css" >
	
	<script src="/templates/<?php echo $this->template ?>/js/slick.min.js"></script>
	<script src="/templates/<?php echo $this->template ?>/js/scripts.js"></script>
	
	

</head>

<body id="<?php echo $page; ?>">
	<header class="header<?php if ($page != 'main') echo " single-header no_shadow"?>">
		<div class="container">
			<div class="header__city">
				<a href="#">Ваш регион Москва ?</a>
			</div>
			<div class="toggle-menu">
				<div></div>
				<div></div>
				<div></div>
			</div>
			<div class="header__menu">
				<span class="mob_x">x</span>
				<?php if ($this->countModules('topmenu')) : ?>
					<jdoc:include type="modules" name="topmenu" style="none" />	
				<?php endif; ?>
			</div>
			<div class="header__logo">
				<a href="/"><?php echo $sitename; ?></a>
			</div>
			<div class="clearFloat"></div>
		</div>
	</header>
	<?php if ($page == 'home') {   /* СЛАЙДЕР НА ГЛАВНОЙ */ ?>
	<section class="slider__home slider-container">
		<?php
		foreach ($params as $key => $item) {
			$num =  explode("_", $key);
			if (($num[0] == 'slider') && ($params['slider_i_' . end($num)] != '') && ($params['slider_i_' . end($num)] != '-1')) {
		?>
				<div class="slider__home-item" style="background-image: url('images/slider/<?php echo $params['slider_i_' . end($num)] ?>')">
					<div class="slider__wrap">
						<h3><?php echo $params['slider_z_' . end($num)] ?></h3>
						<p><?php echo $params['slider_u_' . end($num)] ?></p>
					</div>
				</div>
		<?php
			};
		}
		?>
	</section>
	<?php } ?>
	
	<?php if ($page != 'home') {   /* КОНТЕНТ */ ?>
	<main id="content" role="main">
		<div class="container">			
		<?php if ($this->countModules('breadcrumbs')) : /* МОДУЛЬ "ВЫ ОКАЗЫВАЕТЕ УСЛУГИ В СФЕРЕ КРАСОТЫ?"  */ ?>
		<jdoc:include type="modules" name="breadcrumbs" style="none" />	
		<?php endif; ?>
		<jdoc:include type="message" />
		<?php if ($this->countModules('sidebar')) {$sbar = 'w_sidebar';} else {$sbar = 'wo_sidebar';}; /* САЙТБАР  */ ?>
			<div class="cont_<?php echo $sbar; ?> ">
				<div class="cont">
					<jdoc:include type="component" />
				</div>
				<div class="sbar">
					<jdoc:include type="modules" name="sidebar" style="html5" />
				</div>
			</div>
		</div>			
	</main>
	<?php } ?>
	
	<?php if ($page == 'home') {   /* контент на главной*/ ?>
	<section class="search__section">
		<div class="container">
			<div class="search__coll-left">
				<h2 class="search_title">поиск специалистов</h2>
				<span class="search__sub">Lorem ipsum dolor sit amet</span>
				<form>
					<div class="filed filed1">
						<input type="text" placeholder="Услуга или специальность" />
					</div>
					<div class="filed filed2">
						<input type="text" placeholder="Дата" />
					</div>
					<div class="filed filed3">
						<input type="text" placeholder="Станция метро" />
					</div>
					<span class="form-sub">Популярные запросы: Lorem ipsum dolor sit amet, consectetur</span>
					<input type="submit" class="search-sbmt" value="Поиск" />
				</form>
			</div>
			<p class="search__text">
				Lorem ipsum dolor sit amet, consectetur adipisicingna aliqua. Ut eco laboris nisi ut aliquip ex ea commodo consequat.
			</p>
			<div class="clearFloat"></div>
		</div>
	</section>
	
	<section class="search__catalog">
		<div class="container">
			<h2>поиск по услугам</h2>
                <span class="service__sub">Lorem ipsum dolor sit amet</span>
                <div>
                    <div class="service__item">
                        <div style="background-image: url('images/service1.png')" class="service__img">
                            <div>Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, consec Lorem ipsum dolor sit amet, consec consec</div>
                        </div>
                        <a href="#">Волосы</a>
                        <span>Более 1500 специалистов</span>
                    </div>
                    <div class="service__item">
                        <div style="background-image: url('images/service2.png')" class="service__img">
                            <div>Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, consec Lorem ipsum dolor sit amet, consec consec</div>
                        </div>
                        <a href="#">Ресницы</a>
                        <span>Более 1500 специалистов</span>
                    </div>
                    <div class="service__item">
                        <div style="background-image: url('images/service3.png')" class="service__img">
                            <div>Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, consec Lorem ipsum dolor sit amet, consec consec</div>
                        </div>
                        <a href="#">Ногти</a>
                        <span>Более 1500 специалистов</span>
                    </div>

                    <div class="service__item">
                        <div style="background-image: url('images/service4.png')" class="service__img">
                            <div>Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, consec Lorem ipsum dolor sit amet, consec consec</div>
                        </div>
                        <a href="#">Косметология</a>
                        <span>Более 1500 специалистов</span>
                    </div>
                    <div class="service__item">
                        <div style="background-image: url('images/service5.png')" class="service__img">
                            <div>Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, consec Lorem ipsum dolor sit amet, consec consec</div>
                        </div>
                        <a href="#">Эпиляция</a>
                        <span>Более 1500 специалистов</span>
                    </div>
                    <div class="service__item">
                        <div style="background-image: url('images/service6.png')" class="service__img">
                            <div>Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, consec Lorem ipsum dolor sit amet, consec consec</div>
                        </div>
                        <a href="#">Визаж</a>
                        <span>Более 1500 специалистов</span>
                    </div>
                    <div class="clearFloat"></div>
                </div>
            </div>
	</section>
	<?php } ?>
	<?php if ($this->countModules('addmaster')) : /* МОДУЛЬ "ВЫ ОКАЗЫВАЕТЕ УСЛУГИ В СФЕРЕ КРАСОТЫ?"  */ ?>
	<section class="info__box">
		<div class="container">
		<jdoc:include type="modules" name="addmaster" style="none" />	
		</div>
	</section>
	<?php endif; ?>
	<?php if ($this->countModules('loadapps')) : /* МОДУЛЬ "ЗАГРУЗИТЕ НАШЕ ПРИЛОЖЕНИЕ БЕСПЛАТНО" */ ?>
	<section class="app">
		<div class="container">
			<jdoc:include type="modules" name="loadapps" style="none" />	
			<div class="clearFloat"></div>
		</div>
	</section>
	<?php endif; ?>
	<?php if ($this->countModules('topposts')) : /* МОДУЛЬ "ПОПУЛЯРНЫЕ СТАТЬИ" */ ?>		
	<section class="news">
		<div class="container2">
		<jdoc:include type="modules" name="topposts" style="none" />
		</div>
	</section>
	<?php endif; ?>
	<footer class="footer">
		<div class="container">
			<a class="footer__logo" href="/"><?php echo $sitename; ?></a>
			<jdoc:include type="modules" name="bottommenu" style="none" />
			<div class="bap2">
				<a href="<?php echo $params->get('googleplay') ?>"><img src="/templates/ryba/images/google.png" /></a>
				<a href="<?php echo $params->get('appstore') ?>"><img src="/templates/ryba/images/apple.png" /></a>
			</div>
			<ul class="footer__soc">
				<li> <a href="<?php echo $params->get('facebook') ?>"><img style="width: 15px;height: 15px" src="/templates/ryba/images/fb.png" /></a></li>
				<li> <a href="<?php echo $params->get('instagram') ?>"><img style="width: 17px;height: 15px" src="/templates/ryba/images/i0.png" /></a></li>
				<li> <a href="mailto:<?php echo $params->get('email') ?>"><img src="/templates/ryba/images/cc.png" /></a></li>
				<li> <a href="#"><img src="/templates/ryba/images/sh.png" /></a></li>
			</ul>
			<div class="clearFloat"></div>
		</div>
		<div class="container">
			<span class="copy">@ Все права защищены. 2019-<?php echo date('Y'); ?></span>
		</div>
	</footer>
	<link rel="stylesheet" href="/templates/<?php echo $this->template ?>/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.13.11/jquery.timepicker.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/timepicker@1.13.11/jquery.timepicker.min.js"></script>
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
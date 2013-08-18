<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
	<head>
		<title>Fast Track Sites Professional Newsletter System - <? $page->printTemplateVar("PageTitle");  ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="en-us" />
		<!--Stylesheets Begin-->
			<link rel="stylesheet" type="text/css" href="themes/<?= $pns_config['ftspns_theme']; ?>/main.css" />
			<!--[if lt IE 7]>
				<style>
				</style>
			<![endif]-->			
		<!--Stylesheets End-->
		<!--Javascripts Begin-->
			<script type="text/javascript" src="javascripts/scriptaculous1.8.2.js"></script>	
			<script type="text/javascript" src="javascripts/validation.js"></script>	
			<script type="text/javascript" src="javascripts/functions.js"></script>	
			<script type="text/javascript" src="javascripts/tiny_mce/tiny_mce.js"></script>	
	<!--Javascripts End-->
	</head>
	<body>
		<div id="container">
			<div id="page">
				<div id="header">
					<? $page->printMenu("top", "ul", "", "", "nav", "", ""); ?>
				</div>				
				<div id="left-col">
					<? $page->printSidebar("sidenav", ""); ?>
				</div>
				<div id="right-col">
					<div id="content">
						<? $page->printTemplateVar('PageContent'); ?>	
					</div>
				</div>
				
				<div id="footer">
					<div style="float: right; padding-right: 5px;">
						Powered By: <a href="http://www.fasttracksites.com">Fast Track Sites Professional Newsletter System</a>
					</div>
					Copyright &copy; 2006 Fast Track Sites
				</div>
			</div>
		</div>
	</body>
</html>

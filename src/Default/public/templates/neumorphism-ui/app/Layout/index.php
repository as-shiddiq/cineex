<?php 
$auth = Auth();
$configWeb = configWeb();
?>
<!--

=========================================================
* Neumorphism UI - v1.0.0
=========================================================

* Product Page: https://themesberg.com/product/ui-kits/neumorphism-ui
* Copyright 2020 Themesberg MIT LICENSE (https://www.themesberg.com/licensing#mit)

* Coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="en">
<head> 
	<?php include 'head.php'?>
	<?=$this->renderSection('stylesheet')?>
</head>
<body>
	<?php include 'header.php'?>
    <main>
		<?=$this->renderSection('content')?>
    </main>
	<footer class="d-flex py-5 border-top border-light bg-primary">
	    <div class="container">
	        <div class="row">
	            <div class="col">
	            	<div class="d-flex text-center justify-content-center align-items-center" role="contentinfo">
	                	<p class="font-weight-normal font-small mb-0">Copyright ©
	                    <span class="current-year">2023</span> <?=date('Y')>2023?'- '.date('Y'):''?>. All rights reserved.</p>
	                </div>
	            </div>
	        </div>
	    </div>
	</footer>
	<?php include 'javascript.php'?>
	<?php include 'load/api.php'?>
	<?=$this->renderSection('javascript')?>
</body>
</html>
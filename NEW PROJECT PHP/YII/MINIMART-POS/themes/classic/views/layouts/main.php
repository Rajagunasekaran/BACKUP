<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$baseUrl = Yii::app()->request->baseUrl;
$themePath = (!is_null(Yii::app()->theme))?Yii::app()->theme->baseUrl:$baseUrl;
$cs = Yii::app()->clientScript;
$cs->scriptMap=array(
                'bootstrap-yii.css'=>false,
//            'jquery'=>false, //stop loading jquery js
//            'jquery-ui'=>false, //stop loading jquery-ui js jquery-ui.min.js
            );
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
//loading our own versions...
//css files
//$cs->registerCssFile($baseUrl.'/css/bootstrap.min.css', CClientScript::POS_END);
//$cs->registerCssFile($baseUrl.'/css/jquery-ui.min.css', CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/typography.css', CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/custom.css', CClientScript::POS_END);
$cs->registerCssFile($baseUrl.'/css/slick.css', CClientScript::POS_END);     
//js files
//$cs->registerScriptFile($baseUrl.'/js/jquery.js', CClientScript::POS_END);
//$cs->registerScriptFile($baseUrl.'/js/jquery-ui.min.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/jquery-migrate-1.2.1.min.js', CClientScript::POS_END);
//$cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/bootstrap-hover-dropdown.min.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/slick.min.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/custom.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/appscripts.js', CClientScript::POS_END);
?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div id="toolbar" class="jumbotron">
		<div class="container">
			<div class="row">
				<ul class="navbar-right">
					<li><span class="glyphicon glyphicon-earphone"></span> Call us @ - +91 7676547474, 7676728686, 9035888850</li>
					<?php
                                        echo '<li><a href="'. Yii::app()->request->baseUrl.'/site/login"><span class="glyphicon glyphicon-user"></span> Login</a></li>';
                                        echo '<li class="dropdown">
                                                    <a class="dropdown-toggle js-activated" data-toggle="dropdown" href="#">'. Yii::app()->user->name .' <b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                            <li><a href="' . Yii::app()->request->baseUrl . '/person/update/'. Yii::app()->user->id .'"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
                                                            <li><a href="' . Yii::app()->request->baseUrl . '"><span class="glyphicon glyphicon-lock"></span> Change Password</a></li>';
                                        echo '<li><a href="' . Yii::app()->request->baseUrl . '"><span class="glyphicon glyphicon-credit-card"></span> Payment</a></li>';
                                        echo '<li><a href="' . Yii::app()->request->baseUrl . '"><span class="glyphicon glyphicon-info-sign"></span> Help</a></li>
                                            <li><a href="'. Yii::app()->request->baseUrl .'/site/logout"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
                                            </ul>
                                            </li>';
					?>
				</ul>
			</div>
		</div>
	</div>
    <div id="top" class="jumbotron">
		<div class="container">
			<div id="header" class="row">
				<div class="col-md-3">
					<div class="logo">
						<a href="<?php Yii::app()->request->baseUrl ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="nET-FI" /></a>
					</div>
				</div>
				<div class="col-md-9">
					<?php	
						echo '<nav id="mainMenu" class="navbar navbar-default">
                                                    <div class="container-fluid">
                                                            <div class="navbar-header">
                                                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                                                            <span class="sr-only">Toggle navigation</span>
                                                                            <span class="icon-bar"></span>
                                                                            <span class="icon-bar"></span>
                                                                            <span class="icon-bar"></span>
                                                                    </button>
                                                            </div>
                                                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                                                    <ul class="nav navbar-nav navbar-right">
                                                                            <li><a href="' . Yii::app()->request->baseUrl . '">Home</a></li>
                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/site/page?view=about">About Us</a></li>
                                                                            <li><a href="' . Yii::app()->request->baseUrl . '">Technology</a></li>
                                                                            <li><a href="' . Yii::app()->request->baseUrl . '">Tariffs & Plans</a></li>
                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/site/contact">Contact Us</a></li>
                                                                            <li><a href="' . Yii::app()->request->baseUrl . '">Help</a></li>
                                                                    </ul>
                                                            </div>
                                                    </div>
                                                </nav>';
                                                echo '<nav id="adminMenu" class="navbar navbar-default">
                                                    <div class="container-fluid">
                                                            <div class="navbar-header">
                                                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                                                            <span class="sr-only">Toggle navigation</span>
                                                                            <span class="icon-bar"></span>
                                                                            <span class="icon-bar"></span>
                                                                            <span class="icon-bar"></span>
                                                                    </button>
                                                            </div>
                                                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                                                    <ul class="nav navbar-nav">
                                                                            <li class="dropdown">
                                                                                    <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">Scheme Management <b class="caret"></b></a>
                                                                                    <ul class="dropdown-menu">
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/scheme/create">New Scheme</a></li>
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/schemeType/create">New Scheme Type</a></li>
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/planType/admin">Manage Plan Type</a></li>
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/dataBytes/admin">Manage DataByte</a></li>
                                                                                    </ul>
                                                                            </li>
                                                                            <li class="dropdown">
                                                                                    <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">User Management <b class="caret"></b></a>
                                                                                    <ul class="dropdown-menu">
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/person/create">New Person</a></li>
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/login/admin">Manage Logins</a></li>
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/personScheme/create">Customer Scheme Allotment</a></li>
                                                                                    </ul>
                                                                            </li>
                                                                            <li class="dropdown">
                                                                                    <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">Ticket Management <b class="caret"></b></a>
                                                                                    <ul class="dropdown-menu">
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/tickets/admin">Manage Tickets</a></li>
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/tickets/create">Create New Ticket</a></li>
                                                                                    </ul>
                                                                            </li>
                                                                            <li class="dropdown">
                                                                                    <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown">Settings <b class="caret"></b></a>
                                                                                    <ul class="dropdown-menu">
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/status/create">New Status</a></li>
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/securityQuestions/create">New Security Questions</a></li>
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/modeOfPayment/create">New Mode of Payment</a></li>
                                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/provider/create">Manage Provider</a></li>
                                                                                    </ul>
                                                                            </li>
                                                                            <li><a href="' . Yii::app()->request->baseUrl . '">Reports</a></li>
                                                                            <li><a href="' . Yii::app()->request->baseUrl . '/enquiry/admin">Manage Enquiry</a></li>

                                                                    </ul>
                                                            </div>
                                                    </div>
                                                </nav>';
					?>
				</div>
			</div>
		</div>
	</div>
	
	<div id="mainContent" class="jumbotron">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo $content; ?>
				</div>	
			</div>
		</div>
	</div>	

	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<?php	
						echo '
                                                    <ul>
                                                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a></li>
                                                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/page?view=about">About Us</a></li>
                                                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Technology</a></li>
                                                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Tariffs & Plans</a></li>
                                                            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/contact">Contact Us</a></li>

                                                    </ul>';
					?>
				</div>
				<div class="col-md-5">
					<p class="copyright pull-right">Copyright &copy; <?php echo date('Y'); ?> nET-FI. All Rights Reserved.</p>
				</div>
			</div>
		</div>
	</div>    
  </body>
</html>
<?php
$paramsary = include(dirname(__FILE__)."/../controllers/AppConstants.php");
$paramsary['appID'] = $appIdPOS;
// uncomment the following to define a path alias
 Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('booster', $_SERVER["DOCUMENT_ROOT"] .'/yiibooster');
Yii::setPathOfAlias('mpdf', $_SERVER["DOCUMENT_ROOT"] .'/mpdf571');
Yii::setPathOfAlias('html2pdf', $_SERVER["DOCUMENT_ROOT"] .'/html2pdf');
//Yii::setPathOfAlias('qpdfjs', $_SERVER["DOCUMENT_ROOT"] .'/QPdfJs');
Yii::setPathOfAlias('egmap', $_SERVER["DOCUMENT_ROOT"] .'/EGMap');
Yii::setPathOfAlias('fpdf', $_SERVER["DOCUMENT_ROOT"] .'/fpdf');
Yii::setPathOfAlias('mprint', $_SERVER["DOCUMENT_ROOT"] .'/mPrint');
ini_set('display_errors', 'Off');
date_default_timezone_set('Singapore');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'        
	,'name'=>"Salva's Mart@Esplanade"
        ,'defaultController' => 'site'
        //,'theme' => 'basic'
	// preloading 'log' component
	,'preload'=>array(
            'log'
            , 'booster'
            )

	// autoloading model and component classes
	,'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.controllers.*',
                'application.utils.*',
                'application.extensions.*',
                'booster.*',
                'booster.components.*',
                'booster.widgets.*',
                'booster.helpers.*',
                'booster.actions.*',
                'booster.filters.*',
                'egmap.*',
                'egmap.kml.*',
                'ext.json.*',
                'mprint.*',
                'mprint.mPrint',
	)

	,'modules'=>array(
		// uncomment the following to enable the Gii tool		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'test1234',
                        'generatorPaths' => array('booster.gii'),                        
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('localhost','::1'),
		),
                'dash',
	)
	// application components
	,'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        //'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
		)
                ,'clientScript'=>array(
                                    'coreScriptPosition' => CClientScript::POS_END,
                                )
                ,'booster' => array(
                    'class' => 'booster.components.Booster',
//                    'enableJS'=>false,//for bootstrap js files , but it is already 3.1 only
//                    'bootstrapCss'=>false,// for bootstrap css files 
//                    'jqueryCss'=>false,//for the file jquery-ui-bootstrap.css
//                    'enablePopover'=>false,
//                    'enableTooltip'=>false
                )
		// uncomment the following to enable URLs in path-format
		,'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName'=>false,
                        'caseSensitive' =>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		)
                /*
		,'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		)
		*/
		// uncomment the following to use a MySQL database
		,'db'=>array(
			'connectionString' => "mysql:host=localhost;port=3306;dbname=" . $paramsary['appID'],
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
//                        'enableParamLogging'=>true,
//                        'enableProfiling'=>true,

		)
		,'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		)
		,'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
                                    'class'=>'CFileLogRoute',
                                    'levels'=>'error, warning, vardump, trace',
                                    'logfile' => 'application.log',
                                    ),
				// uncomment the following to show log messages on web pages				
//				array(
//					'class'=>'CWebLogRoute',
//                                        'levels'=>'error warning vardump',
//				),
				
			),
		),
            'mprint'=>array('class'=>'mprint.mPrint')
                ,'ePdf' => array(
                            'class'         => 'ext.yii-pdf.EYiiPdf',
                            'params'        => array(
                                'mpdf'     => array(
                                    'librarySourcePath' => 'mpdf.*',
                                    'constants'         => array(
                                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                                    ),
                                    'class'=>'mpdf', // the literal class filename to be loaded from the vendor folder
                                    /*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                                        'mode'              => '', //  This parameter specifies the mode of the new document.
                                        'format'            => 'A4', // format A4, A5, ...
                                        'default_font_size' => 0, // Sets the default document font size in points (pt)
                                        'default_font'      => '', // Sets the default font-family for the new document.
                                        'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                                        'mgr'               => 15, // margin_right
                                        'mgt'               => 16, // margin_top
                                        'mgb'               => 16, // margin_bottom
                                        'mgh'               => 9, // margin_header
                                        'mgf'               => 9, // margin_footer
                                        'orientation'       => 'P', // landscape or portrait orientation
                                    )*/
                                ),
                                'html2pdf' => array(
                                    'librarySourcePath' => 'html2pdf.*',
                                    'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                                    /*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                                        'orientation' => 'P', // landscape or portrait orientation
                                        'format'      => 'A4', // format A4, A5, ...
                                        'language'    => 'en', // language: fr, en, it ...
                                        'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                                        'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                                        'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                                    )*/
                                )
                            ),
                        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
        'params'=>$paramsary,
);
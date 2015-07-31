<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div id="content">
	<div class="row">
		<div class="col-md-12">
			<div class="well well-sm">
				<div class="btn-group navbar-right">
				<?php
					/*$this->beginWidget('zii.widgets.CPortlet', array(
						//'title'=>'Operations',
					));*/
					foreach($this->menu as $item){
						$hlbl = $item['label'];
						$hurl = $item['url'];
						$hurl = $this->getUniqueId() . '/' . $hurl[0];
						$ahref = '<a class="btn btn-primary btn-xs" href="'. Yii::app()->createUrl($hurl) . '">'. $hlbl . '</a>';
						echo $ahref;
					}
					/*$this->widget('zii.widgets.CMenu', array(
						'items'=>$this->menu,
						'htmlOptions'=>array('class'=>'nav navbar-nav navbar-right'),
					));
					$this->endWidget();*/
				?>
				</div>
			</div>
		</div>
	</div>
	<?php echo $content; ?>
</div><!-- content -->
<!--
<div class="span-5 last">
	<div id="sidebar">
	
	</div>
</div>-->
<?php $this->endContent(); ?>
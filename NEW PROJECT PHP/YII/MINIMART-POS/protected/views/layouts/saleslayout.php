<?php $this->beginContent('//layouts/sales'); ?>
<?php 
    $this->widget(
        'booster.widgets.TbPanel',
        array(
        'title' => $this->subTitle,
        'context' => 'primary',
        'headerIcon' => 'info',
        'content' => $content,
        //'padContent' => false,
        'htmlOptions' => array()
        )
    );
?>
<?php $this->endContent(); ?>
<?php
/* @var $this StateController */
/* @var $data State */
?>

<div class="view">
	<?php echo CHtml::link($data->name,['state/view','id' => $data->id_state]); ?>
</div>
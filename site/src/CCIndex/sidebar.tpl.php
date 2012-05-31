<h3><?=$header?><h3>
<?php if($contents != null):?>
	<?php foreach($contents as $val):?>
		<h6><a href='<?=create_url("page/view/{$val['id']}")?>'><?=esc($val['title'])?></a></h6>
		<!--<p class='smaller-text'><em>Posted on <?=$val['created']?> by <?=$val['owner']?></em></p>-->
		<p class='smaller-text'><?=filter_data($val['data'], $val['filter'])?></p>
	<?php endforeach; ?>
<?php else:?>
	<p>No posts exists.</p>
<?php endif;?>
<h1><?=$header?></h1>
<?php if($contents != null):?>
	<?php foreach($contents as $val):?>
		<h3><a href='<?=create_url("page/view/{$val['id']}")?>'><?=esc($val['title'])?></a></h3>
		<p><?=filter_data($val['data'], $val['filter'])?></p>
		<p class='smaller-text'><em>Posted on <?=$val['created']?> by <?=$val['owner']?></em></p>
	<?php endforeach; ?>
<?php else:?>
	<p>No posts exists.</p>
<?php endif;?>
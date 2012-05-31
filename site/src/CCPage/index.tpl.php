<?php if($content != null):?>
	<h1><?=esc($content['title'])?></h1>
	<p class='smaller-text'><em>Posted on <?=$content['created']?> by <?=$content['owner']?></em></p>
	<p><?=filter_data($content['data'], $content['filter'])?></p>
	<?php if(isset($content['comments'])):?>
		<h4>Comments:</h4>
		<?php foreach($content['comments'] as $val): ?>
			<div style='background-color:#f6f6f6;border:1px solid #ccc;margin-bottom:1em;padding:1em;'>
				<p><?=esc($val['data'])?></p>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<?=$form?>
<?php else:?>
	<p>No posts exists.</p>
<?php endif;?>
<h1><?=at('pages')?></h1>

<table class="table pages_module">
    <td colspan="4" id="buttons" class="hint" name="Add">
            <a href="<?=_cfg('cmssite').'/#pages/add'?>"><div class="add-image"></div><?=at('add_new')?> <?=at('text_page')?></a>
        </td>
	<tr>
        <td width="35%"><b><?=at('page_name')?></b></td>
        <td width="40%"><b><?=at('page_link')?></b></td>
        <td width="15%" class="centered b"><?=at('only_for_logged_in')?></td>
        <td width="10%" align="center"><b><?=at('actions')?></b></td>
    </tr>
	<?
		if ($module->pages) {
			foreach($module->pages as $v) {
				?><tr>
					<td><a href="<?=_cfg('cmssite').'/#pages/edit/'.$v->id?>"><?=$v->link?></a></td>
					<td><a href="<?=_cfg('site').'/en/'.$v->link?>" target="_blank"><?=_cfg('site')?>/{lang}/<?=$v->link?></a></td>
                    <td class="centered">
                        <?=($v->logged_in == 1 ? '<img src='._cfg('cmsimg').'/tick-small.png  class="hint" name="Page available only for logged in users"/>' : '')?>
                    </td>
					<td class="centered">
                        <a href="<?=_cfg('cmssite').'/#pages/edit/'.$v->id?>" class="hint" name="Edit"><img src="<?=_cfg('cmsimg')?>/edit.png" /></a> 
                        <a href="javascript:void(0);" class="hint" name="Delete" onclick="TM.deletion('<?=_cfg('cmssite').'/#pages/delete/'.$v->id?>'); return false;"><img src="<?=_cfg('cmsimg')?>/cancel.png" /></a>
                    </td>
				  </tr><?
			}
		}
	?>
</table>
<div class="container">
    <? if (is_array($message) and array_key_exists('type', $message)) {?>
        <div class="alert alert-<?=$message['type']?>"> <a class="close" data-dismiss="alert" href="#">&times;</a> <? if ($message['type']=='success') {?><span class="glyphicon glyphicon-ok"></span><?}?> <?=$message['text']?></div>
    <? } ?>
<h1 class="page-header">Схема этажа, квартирография</h1>

	<ol class="breadcrumb">
		<li><a href="/admin/blocks#block-<?=$block->id?>"><?=$object->title_object?>, <?=$block->numb_block?></a></li>
		<li>Этаж <?=$floor->numb_floor?></li>
	</ol>


<?
if (empty($floor->plan)){
?>
<div class="row">
	<div class="col-md-12">
		<h3>Загрузить план этажа</h3>
        <form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" id="upload-plan" name="plan">
            </div>
            <input type="submit" name="upload-plan" value="Загрузить" class="btn btn-success">
        </form>
	</div>
</div>
<?
} else {
?>

<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-pills pull-right">
			<li>
				<a class="dropdown-toggle" id="add-area"   href="#" >
					<span class="glyphicon glyphicon-plus" style="color: #777"></span>&nbsp;&nbsp;Отметить квартиру
				</a>
			</li>
            <? if (empty($checked_flats)) {?>
			<li>
				<a class="dropdown-toggle" data-toggle="modal" data-target="#delete-plan-modal" href="#" >
					<span class="glyphicon glyphicon-plus" style="color: #777"></span>&nbsp;&nbsp;Удалить план этажа
				</a>
			</li>
                <form action="/admin/floor/delplan" name="delete-plan-form" method="post">
                    <div class="modal fade" id="delete-plan-modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"><button class="close" type="button" data-dismiss="modal">x</button>
                                    <h4 class="modal-title" id="myModalLabel">Подтвердите удаление плана</h4>
                                </div>
                                <div class="modal-body">

                                    <input type="hidden" name="floor_id" value="<?=$floor->id?>">
                                    <input type="hidden" name="plan" value="<?=$floor->plan?>">
                                </div>
                                <div class="modal-footer"><button class="btn btn-default" type="button" data-dismiss="modal">Отмена</button>
                                    <input type="submit" class="btn btn-primary" value="Удалить"></div>
                            </div>
                        </div>
                    </div>
                </form>
            <?}?>
		</ul>
	</div>
</div>

<div class="row">
<div class="col-md-12">

    <div id="save-block" class="hidden" style="margin-bottom: 30px">
        Отредактируйте и сохраните отметку квартиры
        <form action="/admin/floor/markflat" name="checkfloor-form" method="post" class="form-inline" style="margin-top: 20px">
            <div class="form-group">
                <input type="text" name="numb_flat" id="check_numb_flat" class="form-control"  value="" placeholder="Введите номер квартиры" >
                <input type="hidden" name="curr_numb" id="curr_numb">
                <input type="hidden" name="floor_id" value="<?=$floor->id?>">
                <div  class="hidden">
                    <textarea  rows=3  name="coords"  class="canvas-area" placeholder="Shape Coordinates" data-image-id="#" data-image-url="<?=$floor->plan?>"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
            <button type="button" id="clear-area" class="btn btn-default">Отменить</button>
        </form>
    </div>

    <div class="row preview">
        <div id="canvas-area" class="inner">
         </div>
        <div class="plan">
        <img src="<?=$floor->plan?>" alt="Sample" class="map" usemap="#nav">
        </div>
    </div>

    <map name="nav">
        <? if (!empty($checked_flats)) foreach ($checked_flats as $flat) {?>
        <area id="area-<?=$flat['id']?>"  shape="poly" coords="<?=$flat['coords']?>" title="<?=$flat['numb_flat']?>"  data-maphilight='{"strokeColor":"808080","strokeWidth":1,"fillColor":"808080","fillOpacity":0.8,"alwaysOn":true}'>
        <?}?>

    </map>
</div>
</div>

<?
if (!empty($checked_flats))
{
?>
        <div class="row">
            <div class="col-md-12">
                <h3>Список отмеченных квартир этажа</h3>
                <ul class="list-group" id="floors-list">
                    <? foreach ($checked_flats as $flat) {?>
                    <li id="floor-<?=$flat['numb_flat']?>" class="list-group-item"><a onclick="editarea(<?=$flat['id']?>)" href="#"><?=$flat['numb_flat']?></a><a class="pull-right" href="/admin/floor/delmarkedflat?id=<?=$flat['id']?>" >Удалить</a></li>
                    <?}?>
               </ul>
            </div>
        </div>
<?}?>
<?
}
?>

</div>
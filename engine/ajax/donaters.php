<?php foreach($Engine->query("SELECT * FROM `orders` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 4") as $u) { ?>
    <div data-tooltip="Товар: <?=$u['group']?> &#xa <?=$Engine->date($u['date']." ".$u['time'])?> &#xa" data-tooltip-location="top">
        <img class="imgdon" style="background: rgba(0,0,0,0); border-radius: 20px;" src="https://mc-heads.net/avatar/<?=$u['nick']?>/100">
        <br>
        <p class="text-center" style="font-size: 11px; margin-top: 1px;"><?=$u['nick']?></p>

    </div>
<?php } ?>
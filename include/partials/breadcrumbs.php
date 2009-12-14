<ul class="breadcrumbs">
  <? if(!array_key_exists('Home', $breadcrumbs)): ?>
    <li><a href="index.php">Home</a> &raquo; </li>
  <? endif; ?>
  <? $last_item = end($breadcrumbs); ?>
  <? foreach($breadcrumbs as $crumb => $link): ?>
    <li <? if(!$link): ?>class="here"<? endif; ?>>
      <? if($link): ?><a href="<?= $link ?>"><?= $crumb ?></a> &raquo; <? else: ?><?= $crumb ?><? endif; ?>
    </li>
  <? endforeach; ?>
</ul>

<div class="search">
  <form id="global-search" action="<?= $home_url; ?>" method="get" >
    <label for="search-top" class="hidden">Seek: </label>
    <input type="text" name="s" id="s" value=" " />
    <? if($category): ?>
      <input type="hidden" name="cat" value="<?= $category ?>" />
    <? endif; ?>
    <label for="search-button" class="hidden">Search </label>
    <input type="submit" value=" " id="search-button" name="search-button" />
  </form>
</div>

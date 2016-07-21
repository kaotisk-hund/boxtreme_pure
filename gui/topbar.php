<div class="top-bar">
  <div class="top-bar-left">
	<ul class="dropdown menu" data-dropdown-menu>
        <ul class="menu">
            <li class="menu-text"><?php echo $this->settings['site_name'];?></li>
            <li>
                <?php echo $this->getTopbarMenu('left'); ?>
            </li>
        </ul>
	</ul>
  </div>
  <div class="top-bar-right">
	<ul class="menu">
	<!--  Example search from foundation template
		<li><input type="search" placeholder="Search"></li>
		<li><button type="button" class="button">Search</button></li>
	-->
		<?php echo $this->getTopbarMenu('right'); ?>
	</ul>
  </div>
</div>
<?php
$explodeUrl = explode("?", $_SERVER['REQUEST_URI']);
$urlStr = explode("/", $explodeUrl[0]);
$urlStr = end($urlStr);
$_SESSION['SessionStartTime'] = time();
$user_type = $_SESSION['UserType'];

$ebasta_url_array = array('kashtkarebasta', 'kashtkarsahmati');
$grievance_url_array = array('kashtkargrievance', 'addgrievance');
?>
<ul class="menu-inner py-1 ps ps--active-y">
    <li class="menu-item <?php if (in_array($urlStr, $ebasta_url_array)) { ?>active<?php } ?>">
        <a href="kashtkarsahmati" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">सहमति जमा करें</div>
        </a>
    </li>

    <li class="menu-item <?php if (in_array($urlStr, $grievance_url_array)) { ?>active<?php } ?>">
        <a href="kashtkargrievance" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">शिकायत दर्ज करें</div>
        </a>
    </li>
</ul>
<div class="ps__rail-x" style="left: 0px; bottom: 0px;">
    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
</div>
<div class="ps__rail-y" style="top: 0px; height: 397px; right: 4px;">
    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 176px;"></div>
</div>
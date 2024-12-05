<div id="popup"></div>
<div id="overlay"></div>
<div class="header-fix">
    <div class="header-wrapper">
        <div class="logo left">
            <img src="img/bidalogo.png" alt="" height="50px" />
        </div>
        <div class="profile-wrap right posrel">
            <a style="cursor: pointer;" class="showDropdown">
                <img src="img/settings.svg" alt="" width="18px">
            </a>
            <div class="setting-dropdown posabsolut" style="display: none;">
                <a style="cursor:pointer;" id="change_password">Change Password</a>
                <a style="cursor:pointer;" id="logout">Logout</a>
            </div>
        </div>
        <div class="lngwrap right posrel">
            <a style="cursor: pointer;" class="showLang">
                <img src="img/language.svg" alt="" width="19px">
            </a>
            <div class="setting-dropdown posabsolut" style="display: none;">
                <a class="sel_lng" style="cursor:pointer;" id="en">English</a>
                <a class="sel_lng" style="cursor:pointer;" id="hi">Hindi</a>
            </div>
        </div>

        <?php if ($_SESSION['UserType'] == '0' || $_SESSION['UserType'] == '1') { ?>
            <div class="helpwrap right posrel">
                <a style="cursor: pointer;" class="showNotify">
                    <img src="img/bell-w.svg" alt="" width="19px">
                </a>
                <div class="notifcnt" style="display: none;"></div>
                <div class="posabsolut notif-drawer box-sizing" style="display: none;">
                </div>
            </div>
        <?php } ?>
        <div class="helpwrap right"
             style="color: #fff; font-size: 15px; font-weight: 600;display:flex;align-items:center; margin-top: -10px; margin-bottom: -10px;">
            <div class="project_name">
                <a href="dashboard"><?php echo $_SESSION['UserName']; ?></a>
            </div>

        </div>
        <div class="clr"></div>
    </div>
</div>
<script src="scripts/header.js"></script>
<script src="scripts/timeout.js"></script>
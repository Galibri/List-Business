<div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
    <div class="logo">
        <a hef="index.php"><img src="http://jskrishna.com/work/merkury/images/logo.png" alt="merkery_logo" class="hidden-xs hidden-sm">
            <img src="http://jskrishna.com/work/merkury/images/circle-logo.png" alt="merkery_logo" class="visible-xs visible-sm circle-logo">
        </a>
    </div>
    <div class="navi">
        <ul>
            <li class="active">
                <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Dashboard</span></a>
            </li>
            <?php if(is_admin()) { ?>
            <li>
                <a href="users.php"><i class="fa fa-tasks" aria-hidden="true"></i><span class="hidden-xs hidden-sm">All Users</span></a>
            </li>
            <li>
                <a href="users.php?action=add"><i class="fa fa-bar-chart" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Add New User</span></a>
            </li>
            <?php } ?>
            <li>
                <a href="business.php"><i class="fa fa-user" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Business Lists</span></a>
            </li>
            <li class="hidden-xs">
                <a href="business.php?action=add_listing"><i class="fa fa-building" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Add New Business</a>
            </li>
        </ul>
    </div>
</div>
<div class="col-md-10 col-sm-11 display-table-cell v-align">
    <!--<button type="button" class="slide-toggle">Slide Toggle</button> -->
    <div class="row">
        <header>
            <div class="col-md-7">
                <nav class="navbar-default pull-left">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                </nav>
                <div class="search hidden-xs hidden-sm">
                    Hello <?php echo $_SESSION['username']; ?>
                </div>
            </div>
            <div class="col-md-5">
                <div class="header-rightside">
                    <ul class="list-inline header-top pull-right">
                        <li class="hidden-xs">
                            <a href="business.php?action=add_listing" class="add-project">Add New Business</a>
                        </li>
                        <li class="hidden-xs">
                            <a href="../index.php" target="_blank">Visit Website</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="navbar-content">
                                        <span><?php echo $_SESSION['username']; ?></span>
                                        <p class="text-muted small">
                                            <?php echo $_SESSION['user_email']; ?>
                                        </p>
                                        <div class="divider">
                                        </div>
                                        <a href="logout.php" class="view btn-sm active">Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    </div>
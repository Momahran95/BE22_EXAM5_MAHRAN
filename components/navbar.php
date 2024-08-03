<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="../home.php">Megapet</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-light" aria-current="page" href="../home.php">Home</a>
                </li>
                <?php if (isset($_SESSION["user"])) { ?>
                    <li class="nav-item"><a class="nav-link text-light" href="../user/user_profile.php">My Profile</a></li>
                <?php } ?>

                <?php if (isset($_SESSION["admin"])) { ?>
                    <li class="nav-item"><a class="nav-link text-light" href="../admDashboard/dashboard.php">Dashboard</a></li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link text-light" href="../user/senior.php?senior={$value['age']}">Senior</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php if (isset($_SESSION["admin"])) { ?>
                    <li class="nav-item"><a class="nav-link text-light" href="../admDashboard/create.php">New Animal</a></li>
                <?php } ?>
                <?php if (isset($_SESSION["admin"]) || isset($_SESSION["user"])) { ?>
                    <li class="nav-item"><a class="nav-link text-light" href="../user/logout.php?logout">Logout</a></li>
                <?php } ?>
                <?php if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) { ?>
                    <li class="nav-item"><a class="nav-link text-light" href="../user/login.php">Login</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
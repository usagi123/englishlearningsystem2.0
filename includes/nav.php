<?php require_once 'arrays.php'; ?>

<ul class="navbar-nav ml-auto">
    <!-- <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="listing.php">Listing</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="addnew.php">Add new</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
    </li> -->

    <?php foreach ($navItems as $item): ?>            
        <li class="nav-item <?=$_SESSION['msg_type']?>">
            <a class="nav-link" href="<?php echo $item[slug]?>"><?php echo $item[title]?></a>
        </li>
    <?php endforeach ?>
</ul>
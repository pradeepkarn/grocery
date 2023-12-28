<ul class="nav flex-column">

    <?php if (PASS) : ?>
      
        <?php if (is_superuser()) { ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/categories"> <i class="fa-solid fa-list"></i> Categories </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/products"> <i class="fa-solid fa-list"></i> Products </a>
            </li>
         
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/promotions"> <i class="fa-solid fa-rectangle-list"></i> Promotions </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/coupons"> <i class="fa-solid fa-rectangle-list"></i> Coupons </a>
            </li>
            <?php } ?>
            <?php if (USER['user_group']=="salesman" || USER['user_group']=="admin" || USER['role']=="superuser") { ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/orders"> <i class="fa-solid fa-rectangle-list"></i> Orders </a>
            </li>
            <?php } ?>
            <?php if (USER['user_group']=="whmanager" || USER['user_group']=="admin" || USER['role']=="superuser") { ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/whorders"> <i class="fa-solid fa-rectangle-list"></i> WH-Orders </a>
            </li>
            <?php } ?>
            <hr style="color:white;">
            <?php if (is_superuser()) { ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/sliders"> <i class="fa-solid fa-rectangle-list"></i> Sliders </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/enquiries"> <i class="fa-solid fa-rectangle-list"></i> Enquires </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/all-customers"> <i class="fa-solid fa-users"></i> Customers </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/all-users"> <i class="fa-solid fa-rectangle-list"></i> Salesmen </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/all-whmanagers"> <i class="fa-solid fa-rectangle-list"></i> WH Managers </a>
            </li>
            <hr style="color:white;">
            <?php if (is_superuser()) { ?>
            <li class="nav-item">
                <a class="nav-link text-white" href="/<?php echo home; ?>/admin/pages"> <i class="fa-solid fa-rectangle-list"></i> Pages </a>
            </li>
            <?php } ?>
        <?php } ?>




    <?php endif; ?>

</ul>
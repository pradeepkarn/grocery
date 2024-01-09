<?php

$db = new Dbobjects;
$cats = $db->show("SELECT c.id, c.title, c.banner, (SELECT COUNT(p.id) FROM content p WHERE p.content_group='product' AND p.parent_id=c.id) AS cnt FROM content c WHERE c.content_group = 'listing_category' ORDER BY cnt DESC");

?>

<section class="popular-categories section-padding">
  <div class="container wow animate__animated animate__fadeIn">
    <div class="section-title">
      <div class="title">
        <h3>Featured Categories</h3>
        <ul class="list-inline nav nav-tabs links">
          <?php 
          $fcats = $db->show("SELECT c.id, c.title, c.banner, (SELECT COUNT(p.id) FROM content p WHERE p.content_group='product' AND p.parent_id=c.id) AS cnt FROM content c WHERE c.content_group = 'listing_category' ORDER BY cnt DESC LIMIT 10");
          foreach ($fcats as $key => $fcat) :
            $prodcnt = $fcat['cnt'] ? $fcat['cnt'] : 0;
            $fcat = (object) $fcat;
            if ($prodcnt > 0) :
          ?>
              <li class="list-inline-item nav-item"><a class='nav-link' href='/<?php echo home; ?>/shop'><?php echo $fcat->title; ?></a></li>
          <?php
            endif;
          endforeach; ?>
          <!-- <li class="list-inline-item nav-item"><a class='nav-link' href='shop-grid-right.html'>Coffes & Teas</a></li>
          <li class="list-inline-item nav-item"><a class='nav-link active' href='shop-grid-right.html'>Pet Foods</a></li>
          <li class="list-inline-item nav-item"><a class='nav-link' href='shop-grid-right.html'>Vegetables</a></li> -->
        </ul>
      </div>
      <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow" id="carausel-10-columns-arrows"></div>
    </div>
    <div class="carausel-10-columns-cover position-relative">
      <div class="carausel-10-columns" id="carausel-10-columns">
        <?php foreach ($cats as $key => $cat) :
          $prodcnt = $cat['cnt'] ? $cat['cnt'] : 0;
          $cat = (object) $cat;
          if ($prodcnt > 0) :
        ?>
            <div class="card-2 bg-9 wow animate__animated animate__fadeInUp" data-wow-delay=".<?php echo $key; ?>s">
              <figure class="img-hover-scale overflow-hidden">
                <a href='/<?php echo home; ?>/shop'><img src="/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $cat->banner; ?>" alt="<?php echo $cat->title; ?>" /></a>
              </figure>
              <h6><a href='/<?php echo home; ?>/shop'><?php echo $cat->title; ?></a></h6>
              <span><?php echo $prodcnt; ?> items</span>
            </div>
        <?php
          endif;
        endforeach; ?>
      </div>
    </div>
  </div>
</section>
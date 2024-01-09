<?php
$db = new Dbobjects;
$prods = $db->show("SELECT p.id, p.title, p.banner, p.parent_id AS cat_id, (SELECT c.title FROM content c WHERE c.id = p.parent_id AND c.content_group = 'listing_category') AS cat_name, 
(SELECT GROUP_CONCAT(cd.content SEPARATOR ' ') FROM content_details cd WHERE cd.content_id = p.id AND cd.content_group = 'product_more_img') AS more_img 
FROM content p WHERE p.content_group = 'product' ORDER BY p.id DESC LIMIT 100;");
foreach ($prods as $key => $p) :
    $p = (object) $p;
    $moreimg = explode(" ", $p->more_img);
?>
    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
        <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".<?php echo $key; ?>s">
            <div class="product-img-action-wrap">
                <div class="product-img product-img-zoom">
                    <a href='/<?php echo home; ?>/shop-product-right/?pid=<?php echo $p->id; ?>'>
                        <img class="default-img" src="/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $p->banner; ?>" alt="" />
                        <?php if ($moreimg[0]) { ?>
                            <img class="hover-img" src="/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $moreimg[0]; ?>" alt="" />
                        <?php } ?>
                    </a>
                </div>
                <div class="product-action-1">
                    <a aria-label='Add To Wishlist' class='action-btn' href='shop-wishlist.html'><i class="fi-rs-heart"></i></a>
                    <a aria-label='Compare' class='action-btn' href='shop-compare.html'><i class="fi-rs-shuffle"></i></a>
                    <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                </div>
                <div class="product-badges product-badges-position product-badges-mrg">
                    <span class="hot">Hot</span>
                </div>
            </div>
            <div class="product-content-wrap">
                <div class="product-category">
                    <a href='/<?php echo home; ?>/shop-product-right/?pid=<?php echo $p->id; ?>'>Snack</a>
                </div>
                <h2><a href='/<?php echo home; ?>/shop-product-right/?pid=<?php echo $p->id; ?>'>Seeds of Change Organic Quinoa, Brown, & Red Rice</a></h2>
                <div class="product-rate-cover">
                    <div class="product-rate d-inline-block">
                        <div class="product-rating" style="width: 90%"></div>
                    </div>
                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                </div>
                <div>
                    <span class="font-small text-muted">By <a href='vendor-details-1.html'>NestFood</a></span>
                </div>
                <div class="product-card-bottom">
                    <div class="product-price">
                        <span>$28.85</span>
                        <span class="old-price">$32.8</span>
                    </div>
                    <div class="add-cart">
                        <a class='add' href='shop-cart.html'><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
endforeach; ?>
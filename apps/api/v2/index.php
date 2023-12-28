<?php
$v = "v2";
header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Origin: https://www.example.com');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
import("apps/api/$v/function.php");

if (token_security==true){
    if (getBearerToken()!==sitekey) {
        $msg['msg'] = "Invalid Authorization";
            header("HTTP/1.0 503 Forbiden");
            $msg['msg'] = "503 Forbiden";
            echo json_encode($msg);
        die();
     }
}

$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['urlend'] = end($url);
$GLOBALS['urlprev'] = prev($url);

if ("$url[0]/$v" == "api/$v") {
    if (count($url)>=4) {
//get users
        if ("{$url[2]}/$url[3]" == "get/users") {
            import("apps/api/$v/api.users/api.get.user.php");
            return;
        }
// Sign Up user
        if ("{$url[2]}/$url[3]" == "user/signup") {
            import("apps/api/$v/api.account/api.create.user.php");
            return;
        }
//User signup
        // if ("{$url[2]}/$url[3]" == "user/signup") {
        //     import("apps/api/$v/api.account/api.create.user-chef.php");
        //     return;
        // }
//User update
        if ("{$url[2]}/$url[3]" == "update/user") {
            import("apps/api/$v/api.account/api.update.user.php");
            return;
        }
//get categories
        if ("{$url[2]}/$url[3]" == "get/categories") {
            import("apps/api/$v/api.categories/api.get.categories.php");
            return;
        }
//get categories
        if ("{$url[2]}/$url[3]" == "get/sub-categories") {
            import("apps/api/$v/api.categories/api.get.sub-categories.php");
            return;
        }
//get locations
        if ("{$url[2]}/$url[3]" == "get/locations") {
            import("apps/api/$v/api.locations/api.get.locations.php");
            return;
        }
//get listings
        if ("{$url[2]}/$url[3]" == "get/listings") {
            import("apps/api/$v/api.listings/api.get.listings.php");
            return;
        }
//get listings
        if ("{$url[2]}/$url[3]" == "search/listings") {
            import("apps/api/$v/api.listings/api.search.listings.php");
            return;
        }
//get listings
        if ("{$url[2]}/$url[3]" == "get/listing-by-category") {
            import("apps/api/$v/api.listings/api.get.listing-by-cat.php");
            return;
        }
//get sliders
        if ("{$url[2]}/$url[3]" == "get/sliders") {
            import("apps/api/$v/api.sliders/api.get.sliders.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "get/deal-sliders") {
            import("apps/api/$v/api.sliders/api.get.deal-sliders.php");
            return;
        }
//get sliders
        if ("{$url[2]}/$url[3]" == "get/promotions") {
            import("apps/api/$v/api.promotions/api.get.promotions.php");
            return;
        }
//get banners
        if ("{$url[2]}/$url[3]" == "get/banners") {
            import("apps/api/$v/api.banners/api.get.banners.php");
            return;
        }
// //get packages
//         if ("{$url[2]}/$url[3]" == "get/packages") {
//             import("apps/api/$v/api.packages/api.get.packages.php");
//             return;
//         }
// //buy package
//         if ("{$url[2]}/$url[3]" == "buy/package") {
//             import("apps/api/$v/api.packages/api.buy.package.php");
//             return;
//         }
//My payments
        if ("{$url[2]}/$url[3]" == "my/payment") {
            import("apps/api/$v/api.payments/api.my.payment_by_id.php");
            return;
        }
//My all payments
        if ("{$url[2]}/$url[3]" == "my/all-payments") {
            import("apps/api/$v/api.payments/api.my.all_payments.php");
            return;
        }
//Update Listing
        if ("{$url[2]}/$url[3]" == "update/listing") {
            import("apps/api/$v/api.listings/api.update.listing.php");
            return;
        }
//create Listing
        if ("{$url[2]}/$url[3]" == "create/listing") {
            import("apps/api/$v/api.listings/api.create.listing.php");
            return;
        }
//create enquiry
        if ("{$url[2]}/$url[3]" == "create/enquiry") {
            import("apps/api/$v/api.enquiries/api.create.enquiry.php");
            return;
        }
//get enquiry
        if ("{$url[2]}/$url[3]" == "get/enquiry") {
            import("apps/api/$v/api.enquiries/api.get.enquiries.php");
            return;
        }

//User login
        if ("{$url[2]}/$url[3]" == "user/login") {
            import("apps/api/$v/api.account/api.user.login.php");
            return;
        }
//User login
        if ("{$url[2]}/$url[3]" == "salesman/login") {
            import("apps/api/$v/api.account/api.user-salesman.login.php");
            return;
        }
//User login via token
        if ("{$url[2]}/$url[3]" == "user/login-via-token") {
            import("apps/api/$v/api.account/api.user.token.login.php");
            return;
        }
//get all medias
        if ("{$url[2]}/$url[3]" == "get/medias") {
            import("apps/api/$v/api.gallery/api.medias.php");
            return;
        }
// reset account
        if ("{$url[2]}/$url[3]" == "reset/account") {
            import("apps/api/$v/api.account/api.reset-account.php");
            return;
        }
// Cart System
        if ("{$url[2]}/$url[3]" == "add-to/cart") {
            import("apps/api/$v/api.cart/api.add-to-cart.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "get/cart") {
            import("apps/api/$v/api.cart/api.get-my-cart.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "lets/hold-it") {
            import("apps/api/$v/api.cart/api.hold-my-cart.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "now/checkout") {
            import("apps/api/$v/api.cart/api.checkout.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "cancel/checkout") {
            import("apps/api/$v/api.cart/api.checkout-cancel.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "get/cart-related-products") {
            import("apps/api/$v/api.cart/api.get-cart-rel-prods.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "remove-from/cart") {
            import("apps/api/$v/api.cart/api.remove-from-cart.php");
            return;
        }
// address
        if ("{$url[2]}/$url[3]" == "create/address") {
            import("apps/api/$v/api.address/api.create.address.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "update/address") {
            import("apps/api/$v/api.address/api.update.address.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "delete/address") {
            import("apps/api/$v/api.address/api.delete.address.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "get/address") {
            import("apps/api/$v/api.address/api.get-address.php");
            return;
        }
// Orders
        if ("{$url[2]}/$url[3]" == "get/orders") {
            import("apps/api/$v/api.orders/api.get-my-orders.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "get/salesman-orders") {
            import("apps/api/$v/api.orders/api.get-salesman-orders.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "get/salesman-order-his") {
            import("apps/api/$v/api.orders/api.get-salesman-order-his.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "action/on-order") {
            import("apps/api/$v/api.orders/api.action-on.order.php");
            return;
        }
        
//Sales person
        if ("{$url[2]}/$url[3]" == "get/salespersons") {
            import("apps/api/$v/api.salespersons/api.get-salespersons.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "coupon/verify") {
            import("apps/api/$v/api.coupons/api.verify-coupon.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "get/invoice") {
            import("apps/api/$v/api.orders/api.list.invoices.php");
            return;
        }
        if ("{$url[2]}/$url[3]" == "get/page") {
            import("apps/api/$v/api.pages/api.get.page.php");
            return;
        }

    }
//404
        else{
            header("HTTP/1.0 404 Not Found");
            $msg['msg'] = "404, Page not found";
            echo json_encode($msg);
            return;
        }
}
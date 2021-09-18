//console.log funktion 
var debug = 1;
window.log = function(a){ if ( debug == 1 ) console.log(a || "");};

// Import all the files used in utils
import {utilsExp} from "./components/utils";
import {headerExp} from "./components/header";
import {brandsExp} from "./components/brands";
import {productExp} from "./components/product";
import {produkt_filterExp} from "./components/produkt_filter";
import {udvalgteExp} from "./components/udvalgte_varer";
import {cartExp} from "./components/cart";
import {checkoutExp} from "./components/checkout";
import {favoritterExp} from "./components/favoritter";
import {shop_notice_Exp} from "./components/shop_notice";
import {accountExp} from "./components/account";

//export to index
export const exp = function exports() {
    utilsExp();
    headerExp();  
    brandsExp();
    productExp();
    produkt_filterExp();
    udvalgteExp();
    cartExp();
    checkoutExp();
    favoritterExp();
    shop_notice_Exp();
    accountExp();
}

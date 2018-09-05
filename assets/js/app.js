/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
require('../css/placeholder.css');
require('../css/scrollbar.black.css');
require('semantic-ui-css/semantic.lonis.css');
require('../css/semantic-magic.css');

const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
var $ = require('jquery');
window.$ = window.jQuery = $;

var semantic = require('semantic-ui-css');
var jQueryBridget = require('jquery-bridget');
var InfiniteScroll = require('infinite-scroll');

// make Infinite Scroll a jQuery plugin
jQueryBridget( 'infiniteScroll', InfiniteScroll, $ );

//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(document).ready(function () {

    // Semantic
    $('.ui.sidebar').sidebar({
        transition: 'overlay',
        mobileTransition: 'overlay'
    }).sidebar('attach events', 'a#hamburger-link');

    $('.home .item').tab();
    //$('.ui.dropdown').dropdown({action: "nothing", on: "hover"});

    $("#computer_menu_user").clone().appendTo("#tablet_menu_user");
    $("#sidebar_menu_main").append($("#computer_menu_main").html());

    // init Infinite Scroll
    var $pagination = $('.pagination-feed').infiniteScroll({
        path: '.pagination__next',
        // path: function() {
        //     var pages = /page=([^&]+)/.exec(location.href);
        //     var url = new URL(location.href);
        //     var page = url.searchParams.get("page");
        //     var page = page ? page : '1';

        //     var pageNext = ( parseInt(page) + 1 );
        //     return location.pathname + '?page=' + pageNext;
        // },
        append: '.pagination-item',
        status: '.scroller-status',
        hideNav: '.pagination',
        checkLastPage: true,
        debug: true,
    });

    $('.pagination__next').click(function () {
        $pagination.infiniteScroll('loadNextPage');
        return false;
    });

    // ???
    $('nav.blog-nav a').each(function () {
        var location = window.location.href;
        var link = this.href;
        if (location == link) {
            $(this).addClass('active');
        }
    });
  
    $('#right_menu a').each(function () {
        var location = window.location.href;
        var link = this.href;
        if (location == link) {
            $(this).parent('li').addClass('active');
        }
    });

    // CSRF
    // $.ajaxSetup({
    //     data: {
    //         'csrf_token_lonis' : $.cookie('csrf_cookie_lonis')
    //     }
    // });

});



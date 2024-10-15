(function ($) {
  "use strict";

  // Gallery
  $(".woocommerce-product-gallery__wrapper").addClass(
    "vu_lightbox vu_l-gallery"
  );

  $("body").addClass("woocommerce");

  $(document).ready(function (e) {
    // Header
    $(".vu_wc-page .woocommerce-result-count")
      .next(".woocommerce-ordering")
      .andSelf()
      .wrapAll('<div class="vu_wc-header clearfix"/>');

    // Mini Cart
    $(".add_to_cart_button").on("click", function () {
      var product_name = $(this).attr("data-name");

      $(".vu_wc-cart-notification")
        .stop(true, true)
        .fadeOut(400, function () {
          $(this).find(".vu_wc-item-name").text(product_name);
        });
    });

    $(".vu_wc-cart-notification").hover(function () {
      $(this).stop(true, true).fadeOut(400);
    });

    $(".vu_wc-menu-item").hover(
      function () {
        if (!$(this).find(".vu_wc-cart-notification").is(":visible")) {
          $(this).find(".vu_wc-cart").stop(true, true).fadeIn(400);
        }
      },
      function () {
        $(this).find(".vu_wc-cart").stop(true, true).fadeOut(400);
      }
    );

    // Input Checkbox
    var vu_wc_checkbox = function ($this) {
      if (!$this.length || $this.prev("span.vu_input-checkbox").length > 0) {
        return false;
      }

      var $vu_checkbox = $("<span></span>")
        .addClass("vu_input-checkbox")
        .html('<i class="fa fa-check"></i>');

      if ($this.is(":checked")) {
        $vu_checkbox.addClass("checked");
      }

      $this.hide();

      $vu_checkbox.insertBefore($this);

      $this.on("change", function () {
        if ($this.is(":checked")) {
          $this.prev(".vu_input-checkbox").addClass("checked");
        } else {
          $this.prev(".vu_input-checkbox").removeClass("checked");
        }
      });

      $vu_checkbox.on("click", function () {
        if (!$this.parent().is("label")) {
          $this.trigger("click");
        }
      });
    };

    $('.woocommerce input[type="checkbox"]').each(function () {
      vu_wc_checkbox($(this));
    });

    // Input Radio
    $('.woocommerce .ywapo_input[type="radio"]:checked').trigger("change");

    // YWAPO
    $(".woocommerce select.ywapo_input").addClass("form-control");

    // Variable
    $(".woocommerce .variations_form .variations select").addClass(
      "form-control"
    );

    // Pagination
    if (!$.fn.yit_infinitescroll) {
      $(".woocommerce-pagination ul.page-numbers")
        .addClass("vu_p-list list-unstyled")
        .removeClass("page-numbers");
      $(".woocommerce-pagination")
        .addClass("vu_pagination")
        .removeClass("woocommerce-pagination");
    }

    // Quantity
    var vu_wc_quantity = function () {
      var $vu_wc_quantity = $(".woocommerce .quantity .qty");

      $vu_wc_quantity.each(function (index, value) {
        var $this = $(this),
          $parent = $this.parent(".quantity").addClass("clearfix");

        if (!$parent.find(".vu_qty-button").length) {
          var $button = $("<button/>")
            .attr({ type: "button" })
            .addClass("vu_qty-button");

          $button
            .clone()
            .html('<i class="vu_fm-remove"></i>')
            .addClass("minus")
            .insertBefore($this);
          $button
            .html('<i class="vu_fm-add"></i>')
            .addClass("plus")
            .insertAfter($this);
        }
      });
    };

    vu_wc_quantity();

    $(document.body).on("click", ".vu_qty-button", function (e) {
      e.preventDefault();

      var $this = $(this),
        $qty = $this.parent(".quantity").find(".qty"),
        value = $qty.val() || 0;

      if ($this.hasClass("minus")) {
        if (value > 1)
          $qty
            .val(parseInt(value) - parseInt($qty.attr("step")))
            .trigger("change");
      } else if ($this.hasClass("plus")) {
        $qty
          .val(parseInt(value) + parseInt($qty.attr("step")))
          .trigger("change");
      }
    });

    // Show WC content with animation
    var vu_wc_show_content = function () {
      var $el = $(".vu_content .woocommerce");

      if ($el.length) {
        $el.wait(100).addClass("vu_with-animation").animateCss("fadeIn");
      }
    };

    vu_wc_show_content();

    // Update cart count in menu
    var vu_wc_update_cart_count = function ($els) {
      var $count = $(".vu_wc-menu-item .vu_wc-count"),
        count = 0;

      if ($els.length) {
        $els.each(function () {
          var $this = $(this),
            re = /(^\d+)/,
            m;

          if (
            (m = re.exec($this.is("input") ? $this.val() : $this.text())) !==
            null
          ) {
            count += parseInt(m[0]);
          }
        });
      }

      if ($count.length) {
        $count.text(count);
      }
    };

    // Event: 'added_to_cart'
    $(document.body).on("added_to_cart", function (e, fragments) {
      $(".vu_wc-menu-item .vu_wc-cart-notification")
        .stop(true, true)
        .fadeIn(400);

      var t = setTimeout(function () {
        $(".vu_wc-menu-item .vu_wc-cart-notification")
          .stop(true, true)
          .fadeOut(400);
        clearTimeout(t);
      }, 3000);

      vu_wc_quantity();
    });

    // Events: 'added_to_cart' and 'removed_from_cart'
    $(document.body).on(
      "added_to_cart removed_from_cart",
      function (e, fragments) {
        vu_wc_update_cart_count(
          $(fragments["div.widget_shopping_cart_content"]).find(".quantity")
        );
      }
    );

    // Event: 'updated_wc_div'
    $(document.body).on("updated_wc_div", function () {
      vu_wc_update_cart_count(
        $("table.woocommerce-cart-form__contents input.qty")
      );

      vu_wc_quantity();

      $(".woocommerce .cross-sells > h2").addClass("vu_wc-heading");
      $(".woocommerce .cart_totals > h2").addClass("vu_wc-heading");

      vu_wc_show_content();

      $(document.body).trigger("wc_fragment_refresh");
    });

    // Event: 'wc_cart_emptied'
    $(document.body).on("wc_cart_emptied", function () {
      vu_wc_show_content();
    });

    // Event: 'updated_checkout'
    $(document.body).on("updated_checkout", function () {
      $(".input-text").addClass("form-control");

      vu_wc_checkbox($('#terms[type="checkbox"]'));
    });

    // WC Checkout
    $(document).on(
      "change",
      "#billing_country, #shipping_country",
      function () {
        $(".input-text").addClass("form-control");
      }
    );

    // WC Classes
    $(".woocommerce-billing-fields > h3").addClass("vu_wc-heading");
    $(".woocommerce-additional-fields > h3").addClass("vu_wc-heading");
    $(".woocommerce-shipping-fields > h3").addClass("vu_wc-heading");
    $(".woocommerce #order_review_heading").addClass("vu_wc-heading");
    $(".woocommerce .cross-sells > h2").addClass("vu_wc-heading");
    $(".woocommerce .cart_totals > h2").addClass("vu_wc-heading");

    $("#billing_country_field label + strong").addClass("form-control");

    // My Account Pages
    $(".woocommerce-account .woocommerce:not(.widget)")
      .parent(".vu_c-wrapper")
      .addClass("p-b-0");
    $(
      ".woocommerce-account .woocommerce .woocommerce-LostPassword > a"
    ).addClass("vu_link-inverse");
    $(".woocommerce-account .woocommerce-MyAccount-navigation")
      .parents(".vu_c-wrapper")
      .addClass("p-b-0");
    $(".woocommerce-account .woocommerce-MyAccount-navigation")
      .parents(".woocommerce")
      .addClass("row m-b-40");
    $(".woocommerce-account .woocommerce-MyAccount-navigation").addClass(
      "col-md-3 m-b-30"
    );
    $(".woocommerce-account .woocommerce-MyAccount-content").addClass(
      "col-md-9 m-b-30"
    );

    // Menu
    $(".woocommerce-MyAccount-navigation").addClass("widget_nav_menu");
    $(".woocommerce-MyAccount-navigation > ul").addClass("menu");
    $(".woocommerce-MyAccount-navigation li.is-active").addClass(
      "current-menu-item"
    );

    // Others Pages
    $(".woocommerce-account .woocommerce h2").addClass("vu_wc-heading");
    $(".woocommerce-account .woocommerce h3").addClass("vu_wc-heading");
    $(".woocommerce .edit-account legend").addClass("vu_wc-heading");

    $('.woocommerce-account .woocommerce input[type="text"]').addClass(
      "form-control"
    );
    $('.woocommerce-account .woocommerce input[type="email"]').addClass(
      "form-control"
    );
    $('.woocommerce-account .woocommerce input[type="password"]').addClass(
      "form-control"
    );
    $(".woocommerce-account .woocommerce select").addClass("form-control");
    $(".woocommerce-account .woocommerce textarea").addClass("form-control");

    $(".input-text").addClass("form-control");

    $(".woocommerce-account .woocommerce-MyAccount-navigation").removeClass(
      "woocommerce-MyAccount-navigation"
    );
    $(".woocommerce-account .woocommerce-MyAccount-content").removeClass(
      "woocommerce-MyAccount-content"
    );

    // Shipping Calculator
    $('.woocommerce .shipping-calculator-form input[type="text"]').addClass(
      "form-control"
    );
    $(".woocommerce .shipping-calculator-form select").addClass("form-control");
    $(".woocommerce .shipping-calculator-form textarea").addClass(
      "form-control"
    );

    // Comment Form
    $('.woocommerce #review_form #commentform input[type="text"]').addClass(
      "form-control"
    );
    $('.woocommerce #review_form #commentform input[type="email"]').addClass(
      "form-control"
    );
    $(".woocommerce #review_form #commentform select").addClass("form-control");
    $(".woocommerce #review_form #commentform textarea").addClass(
      "form-control"
    );
    $(".woocommerce #review_form #commentform #submit")
      .addClass("button alt")
      .attr({ id: "" });

    // Single Product
    $(".woocommerce div.product .woocommerce-tabs").before(
      '<div class="clear"></div>'
    );

    // WC Sorting
    var $vu_dropdown = $("select.orderby");

    $vu_dropdown.each(function () {
      $(this).vu_DropDown();
    });

    // YITH Infinite Scrolling
    $(document).on("yith_infs_added_elem", function () {
      var $vu_lazy_load = $(".vu_lazy-load:not(.vu_img-loaded)");

      $vu_lazy_load.each(function () {
        var $this = $(this),
          img = $this.data("img") || false;

        if (img != false) {
          $("<img/>")
            .attr("src", img)
            .load(function () {
              $(this).remove();
              $this.css("background-image", "url(" + img + ")");
              $this.addClass("vu_img-loaded");
            });
        }
      });
    });

    // Shop page & Category display
    $(
      "body.woocommerce.vu_wc-shop-display-both .vu_wc-products .vu_wc-category ~ div.vu_wc-product-container, body.woocommerce.vu_wc-category-display-both .vu_wc-products .vu_wc-category ~ div.vu_wc-product-container"
    ).wrapAll(
      '<div class="vu_wc-products-container clearfix" data-columns="' +
        $(".vu_content .vu_wc-products[data-columns]").attr("data-columns") +
        '"></div>'
    );

    $(
      "body.woocommerce.vu_wc-shop-display-both .vu_wc-products .vu_wc-products-container, body.woocommerce.vu_wc-category-display-both .vu_wc-products .vu_wc-products-container"
    ).before('<div class="clear"></div>');

    // Quantity input on Product item
    $(".vu_wc-product .vu_p-quantity .quantity .qty").on("change", function () {
      var $this = $(this),
        $product = $this.parents(".vu_wc-product"),
        $add_to_cart = $product.find(".vu_p-i-cart");

      $add_to_cart.attr({ "data-quantity": $this.val() });
    });
  });

  // WC Sorting Custom Dropdown
  $.fn.vu_DropDown = function (options) {
    var $this = this,
      $dropdown = $("<div></div>").addClass("vu_dropdown"),
      $options = $("<ul></ul>").addClass("vu_dd-options"),
      $placeholder = $("<span></span>").text(
        $this.find("option:selected").text()
      );

    $placeholder.appendTo($dropdown);
    $options.appendTo($dropdown);

    $this.find("option").each(function (index, value) {
      $("<li></li>")
        .attr({ "data-value": $(this).attr("value") })
        .text($(this).text())
        .appendTo($options);
    });

    $options.find('li[data-value="' + $this.val() + '"]').addClass("active");

    $dropdown.on("click", function (e) {
      $(this).toggleClass("active");
      return false;
    });

    $options.find("li").on("click", function () {
      $this.val($(this).data("value")).trigger("change");
      $placeholder.text($(this).text());

      //active class
      $options.find("li").removeClass();
      $(this).addClass("active");
    });

    $this.hide();

    $dropdown.insertAfter($this);

    $(document).on("click", function () {
      $(".vu_dropdown").removeClass("active");
    });
  };
})(jQuery);

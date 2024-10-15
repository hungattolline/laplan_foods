(function ($) {
  $(function () {
    // Converters
    var Universal = {
      toJson: function ($el) {
        var $items = $el.find(".vu_param_u-item-container"),
          $value = $el.find(".vu_param_u-value"),
          value = [];

        $items.each(function () {
          var $this = $(this),
            $inputs = $this.find("input, select, textarea"),
            input = {};

          $inputs.each(function () {
            var $input = $(this),
              name = $input.attr("name");

            if (typeof name !== typeof undefined && name !== false) {
              if ($input.is("input:radio") || $input.is("input:checkbox")) {
                input[name] = $input.filter(":checked").val();
              } else {
                input[name] = $input.val();
              }
            }
          });

          value.push(input);
        });

        $el.find(".vu_param_u-items").attr({ "data-count": $items.length });

        $value.val(window.btoa(encodeURIComponent(JSON.stringify(value))));
      },
      fromJson: function ($el) {
        var $container = $el.find(".vu_param_universal"),
          $template = $container.find("#vu_param_u-template"),
          $items = $container.find(".vu_param_u-items"),
          value = [];

        try {
          var _value =
            vc.active_panel.model.attributes.params[
              $el.attr("data-vc-shortcode-param-name")
            ];

          $el.find(".wpb_vc_param_value").val(_value);

          value = JSON.parse(decodeURIComponent(window.atob(_value)));
        } catch (err) {}

        for (var k in value) {
          $items.append($template.html());

          for (var name in value[k]) {
            var $input = $items
              .find(".vu_param_u-item-container")
              .eq(k)
              .find('[name="' + name + '"]');

            if ($input.is("input:radio") || $input.is("input:checkbox")) {
              $input
                .filter('[value="' + value[k][name] + '"]')
                .attr({ checked: "checked" });
            } else {
              $input.val(value[k][name]);

              // Only for Media Param
              if ($input.hasClass("vu_param_m-img-url")) {
                if (value[k][name] != "") {
                  $input.parents(".vu_param_media").addClass("vu_has-img");
                  $items
                    .find(".vu_param_u-item-container")
                    .eq(k)
                    .find(".vu_param_m-img")
                    .css({ "background-image": "url(" + value[k][name] + ")" });
                }
              }
            }
          }
        }

        if ($items.find(".vu_param_u-item-container").length == 0) {
          $items.append($template.html());
        }

        $items.attr({
          "data-count": $items.find(".vu_param_u-item-container").length,
        });
      },
    };

    // Media frame
    var vu_vc_media_frame;

    $(document.body).on(
      "click.vu_vcOpenMediaManager",
      '.vu_param_m-btn[data-control="upload"]',
      function (e) {
        e.preventDefault();

        var $this = $(this);

        vu_vc_media_frame = wp.media.frames.vu_vc_media_frame = wp.media({
          className: "media-frame vu_media-frame vu_vc_media-frame",
          toolbar: "main-insert",
          filterable: "uploaded",
          multiple: $this.hasClass("multiple") ? "add" : false,
          title: $this.data("title"),
          library: {
            type:
              $this.data("type") !== undefined ? $this.data("type") : "image",
          },
          button: {
            text: $this.data("button"),
          },
        });

        vu_vc_media_frame.on("select", function () {
          var $container = $this.parents(".vu_param_media"),
            media_attachment = vu_vc_media_frame
              .state()
              .get("selection")
              .first()
              .toJSON();

          $container
            .find(".vu_param_m-img-id")
            .val(media_attachment.id)
            .trigger("change");

          $container
            .addClass("vu_has-img")
            .find(".vu_param_m-img-url")
            .val(media_attachment.url)
            .trigger("change");
          $container
            .find(".vu_param_m-img")
            .css({ "background-image": "url(" + media_attachment.url + ")" });

          if ($this.hasClass("vu_as-param")) {
            var value = {
              id: media_attachment.id,
              url: media_attachment.url,
            };

            $container
              .find(".vu_param_m-value")
              .val(window.btoa(encodeURIComponent(JSON.stringify(value))));
          }
        });

        vu_vc_media_frame.open();
      }
    );

    // Remove Media
    $(document).on(
      "click",
      '.vu_param_media .vu_param_m-btn[data-control="remove"]',
      function (e) {
        e.preventDefault();

        var $this = $(this),
          $container = $this.parents(".vu_param_media");

        $container.removeClass("vu_has-img");

        $container.find(".vu_param_m-img-id").val("").trigger("change");

        $container.find(".vu_param_m-img-url").val("").trigger("change");
        $container.find(".vu_param_m-img").css({ "background-image": "" });

        if ($this.hasClass("vu_as-param")) {
          $container.find(".vu_param_m-value").val("");
        }
      }
    );

    // Image Select Param
    $(document).on(
      "click",
      ".vu_param_image-select .vu_param_is-images > span",
      function (e) {
        e.preventDefault();

        var $this = $(this),
          $input = $this
            .parents(".vu_param_image-select")
            .find("input.vu_param_is-value");

        $this
          .parents(".vu_param_is-images")
          .find("> span")
          .removeClass("selected");
        $this.addClass("selected");

        $input.val($this.attr("data-id")).trigger("change");
      }
    );

    // Icon Picker - Trigger change event on select icon
    $(document).on("iconpickerSelected", ".vu_iconpicker", function (e) {
      e.preventDefault();

      $(this).trigger("change");
    });

    // Add More
    $(document).on(
      "click",
      ".vu_param_universal .vu_param_u-add-item",
      function (e) {
        e.preventDefault();

        var $this = $(this),
          $container = $this.parent(".vu_param_universal"),
          $template = $container.find("#vu_param_u-template"),
          $items = $container.find(".vu_param_u-items");

        $items.append($template.html());

        try {
          $(".vu_iconpicker").iconpicker();
        } catch (err) {}

        Universal.toJson($container);
      }
    );

    // Delete
    $(document).on(
      "click",
      '.vu_param_universal .vu_param_u-item-btn[data-control="delete"]',
      function (e) {
        e.preventDefault();

        var $this = $(this),
          $container = $this.parents(".vu_param_universal"),
          $item = $this.parents(".vu_param_u-item-container");

        $item.remove();

        Universal.toJson($container);
      }
    );

    // Clone
    $(document).on(
      "click",
      '.vu_param_universal .vu_param_u-item-btn[data-control="clone"]',
      function (e) {
        e.preventDefault();

        var $this = $(this),
          $container = $this.parents(".vu_param_universal"),
          $item = $this.parents(".vu_param_u-item-container");

        $item.clone().insertAfter($item);

        try {
          $(".vu_iconpicker").iconpicker();
        } catch (err) {}

        Universal.toJson($container);
      }
    );

    // On change fields
    $(document).on(
      "change",
      ".vu_param_universal input, .vu_param_universal select, .vu_param_universal textarea",
      function () {
        var $this = $(this),
          $container = $this.parents(".vu_param_universal");

        Universal.toJson($container);
      }
    );

    // On Panel shown
    $(document).on("vcPanel.shown", function (e) {
      // Universal
      var $universal_params = $(
        '.vc_shortcode-param[data-param_type="universal"]'
      );

      $universal_params.each(function () {
        Universal.fromJson($(this));
      });

      // Sortable
      $(".vu_param_universal .vu_param_u-items").sortable({
        cursor: "move",
        axis: "y",
        handle: '.vu_param_u-item-btn[data-control="move"]',
        items: "> .vu_param_u-item-container",
        opacity: 0.7,
        update: function (event, ui) {
          var $container = $(event.target).parents(".vu_param_universal");

          Universal.toJson($container);
        },
      });

      // Media
      var $media_params = $('.vc_shortcode-param[data-param_type="media"]');

      $media_params.each(function () {
        var $this = $(this),
          media = {};

        try {
          media = JSON.parse(
            decodeURIComponent(
              window.atob($this.find(".wpb_vc_param_value").val())
            )
          );
        } catch (err) {}

        if ("id" in media && "url" in media) {
          $this
            .find(".vu_param_m-img")
            .css({ "background-image": "url(" + media.url + ")" });

          $this.find(".vu_param_media").addClass("vu_has-img");
          $this.find(".vu_param_m-img-id").val(media.id);
          $this.find(".vu_param_m-img-url").val(media.url);
        }
      });

      // Select2
      var $vu_param_select2 = $(".vu_param_select2 .vu_param_s2-select");

      $vu_param_select2.each(function () {
        var $this = $(this),
          $container = $this.parents(".vu_param_select2"),
          options = $this.data("options") || {};

        try {
          $this.select2(options);
          $this
            .next(".select2")
            .addClass(
              "vu_param_select2-container" +
                (" " + (options["extraCssClass"] || ""))
            );

          $this.on("select2:open", function (evt) {
            $("body > .select2-container").addClass(
              "vu_param_select2-outer-container"
            );

            if ($this.is("[multiple]")) {
              $("body > .select2-container").addClass("vu_param_s2-multiple");
            }
          });

          $this.on("change", function () {
            var value = $this.val(),
              alias = $this.attr("data-alias");

            $container.find(".wpb_vc_param_value").val(value);
            $this.attr({ "data-value": value });

            if (typeof alias !== typeof undefined && alias !== false) {
              var text = $this.find("option:selected").text();

              $(
                '.vu_param_al-value.wpb_vc_param_value[name="' + alias + '"]'
              ).val(text);
            }
          });

          if (options.source) {
            $.getJSON(options.source, function (data) {
              $.each(data, function (i, item) {
                $this.append(
                  '<option value="' +
                    item.id +
                    '"' +
                    (item.selected == true ? " selected" : "") +
                    ">" +
                    item.text +
                    "</option>"
                );
              });

              $this.trigger("change");
            });
          }
        } catch (err) {}
      });

      // Icon Picker
      try {
        $(".vu_iconpicker").iconpicker();
      } catch (err) {}
    });
  });
})(jQuery);

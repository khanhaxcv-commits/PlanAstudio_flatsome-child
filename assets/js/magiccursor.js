(function ($) {
  "use strict";

  class Cursor {
    constructor(options) {
      this.options = $.extend(
        true,
        {
          container: "body",
          speed: 0.7,
          ease: "expo.out",
          visibleTimeout: 300,
        },
        options,
      );

      this.body = $(this.options.container);
      this.el = $('<div class="cb-cursor"></div>');
      this.text = $('<div class="cb-cursor-text"></div>');
      this.visible = false;
      this.pos = {
        x: -window.innerWidth,
        y: -window.innerHeight,
      };

      this.init();
    }

    init() {
      this.el.append(this.text);
      this.body.append(this.el);
      this.body.addClass("has-magic-cursor");

      this.bind();
      this.move(-window.innerWidth, -window.innerHeight, 0);
    }

    bind() {
      const self = this;

      this.body
        .on("mouseleave", function () {
          self.hide();
        })
        .on("mouseenter", function () {
          self.show();
        })
        .on("mousemove", function (e) {
          self.pos = {
            x: self.stick
              ? self.stick.x - (self.stick.x - e.clientX) * 0.15
              : e.clientX,
            y: self.stick
              ? self.stick.y - (self.stick.y - e.clientY) * 0.15
              : e.clientY,
          };

          self.update();
        })
        .on("mousedown", function () {
          self.setState("-active");
        })
        .on("mouseup", function () {
          self.removeState("-active");
        })
        .on("mouseenter", "a,input,textarea,button", function () {
          self.setState("-pointer");
        })
        .on("mouseleave", "a,input,textarea,button", function () {
          self.removeState("-pointer");
        })
        .on("mouseenter", "iframe", function () {
          self.hide();
        })
        .on("mouseleave", "iframe", function () {
          self.show();
        })
        .on("mouseenter", "[data-cursor]", function () {
          self.setState(this.dataset.cursor);
        })
        .on("mouseleave", "[data-cursor]", function () {
          self.removeState(this.dataset.cursor);
        })
        .on("mouseenter", "[data-cursor-text]", function () {
          self.setText(this.dataset.cursorText);
        })
        .on("mouseleave", "[data-cursor-text]", function () {
          self.removeText();
        })
        .on("mouseenter", "[data-cursor-stick]", function () {
          self.setStick(this.dataset.cursorStick);
        })
        .on("mouseleave", "[data-cursor-stick]", function () {
          self.removeStick();
        });
    }

    setState(state) {
      this.el.addClass(state);
    }

    removeState(state) {
      this.el.removeClass(state);
    }

    setText(text) {
      this.text.html(text);
      this.el.addClass("-text");
    }

    removeText() {
      this.el.removeClass("-text");
      this.text.html("");
    }

    setStick(el) {
      const target = $(el);

      if (!target.length) {
        return;
      }

      const bound = target.get(0).getBoundingClientRect();

      this.stick = {
        y: bound.top + target.height() / 2,
        x: bound.left + target.width() / 2,
      };

      this.move(this.stick.x, this.stick.y, 5);
    }

    removeStick() {
      this.stick = false;
    }

    update() {
      this.move();
      this.show();
    }

    move(x, y, duration) {
      if (typeof gsap === "undefined") {
        return;
      }

      gsap.to(this.el, {
        x: typeof x !== "undefined" ? x : this.pos.x,
        y: typeof y !== "undefined" ? y : this.pos.y,
        force3D: true,
        overwrite: true,
        ease: this.options.ease,
        duration: this.visible ? duration || this.options.speed : 0,
      });
    }

    show() {
      if (this.visible) {
        return;
      }

      clearTimeout(this.visibleInt);
      this.el.addClass("-visible");

      this.visibleInt = setTimeout(() => {
        this.visible = true;
      });
    }

    hide() {
      clearTimeout(this.visibleInt);
      this.el.removeClass("-visible");

      this.visibleInt = setTimeout(() => {
        this.visible = false;
      }, this.options.visibleTimeout);
    }
  }

  $(window).on("load", function () {
    if (window.innerWidth > 991 && typeof gsap !== "undefined") {
      window.nkMagicCursor = new Cursor();
    }
  });
})(jQuery);

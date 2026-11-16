(function () {
  var header = document.querySelector(".site-header");
  var toTop = document.querySelector(".to-top");
  var drawer = document.querySelector("[data-drawer]");
  var mobileNav = document.querySelector("[data-mobile]");
  var lightbox = document.querySelector("[data-lightbox-root]");
  var lightboxImg = lightbox ? lightbox.querySelector("img") : null;

  function toggle(el, open) {
    if (!el) return;
    el.classList.toggle("is-open", open);
    document.body.style.overflow = open ? "hidden" : "";
  }

  document.addEventListener("click", function (event) {
    var openDrawer = event.target.closest("[data-open-drawer]");
    var openMobile = event.target.closest("[data-open-mobile]");
    var close = event.target.closest("[data-close]");
    var shot = event.target.closest("[data-lightbox]");

    if (openDrawer) {
      event.preventDefault();
      toggle(drawer, true);
    }
    if (openMobile) {
      event.preventDefault();
      toggle(mobileNav, true);
    }
    if (close) {
      toggle(close.closest(".drawer, .mobile-nav, .lightbox"), false);
    }
    if (shot) {
      event.preventDefault();
      if (lightboxImg) {
        lightboxImg.src = shot.getAttribute("href");
        lightboxImg.alt = shot.querySelector("img") ? shot.querySelector("img").alt : "";
      }
      toggle(lightbox, true);
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key !== "Escape") return;
    toggle(drawer, false);
    toggle(mobileNav, false);
    toggle(lightbox, false);
  });

  window.addEventListener("scroll", function () {
    var y = window.scrollY || document.documentElement.scrollTop;
    if (header) header.classList.toggle("is-stuck", y > 12);
    if (toTop) toTop.classList.toggle("is-on", y > 500);
  }, { passive: true });

  if (toTop) {
    toTop.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  document.querySelectorAll(".faq-item button").forEach(function (button) {
    button.addEventListener("click", function () {
      var item = button.closest(".faq-item");
      var open = item.classList.contains("is-open");
      item.parentElement.querySelectorAll(".faq-item").forEach(function (other) {
        other.classList.remove("is-open");
        other.querySelector("button").setAttribute("aria-expanded", "false");
      });
      if (!open) {
        item.classList.add("is-open");
        button.setAttribute("aria-expanded", "true");
      }
    });
  });

  document.querySelectorAll("[data-slider]").forEach(function (root) {
    var track = root.querySelector(".slider-track");
    var slides = track ? Array.prototype.slice.call(track.children) : [];
    if (!slides.length) return;

    var index = 0;
    var fade = root.hasAttribute("data-fade");
    var dotsBox = root.querySelector(".dots");
    var timer = null;

    function perView() {
      var w = window.innerWidth;
      if (w < 720) return Number(root.dataset.xs || 1);
      if (w < 1100) return Number(root.dataset.md || 1);
      return Number(root.dataset.lg || 1);
    }

    function maxIndex() {
      return Math.max(0, slides.length - (fade ? 1 : perView()));
    }

    function paintDots() {
      if (!dotsBox) return;
      var count = maxIndex() + 1;
      if (dotsBox.children.length !== count) {
        dotsBox.innerHTML = "";
        for (var i = 0; i < count; i += 1) {
          var dot = document.createElement("button");
          dot.type = "button";
          dot.setAttribute("aria-label", "Depoimento " + (i + 1));
          dot.dataset.go = String(i);
          dotsBox.appendChild(dot);
        }
      }
      Array.prototype.forEach.call(dotsBox.children, function (dot, i) {
        dot.classList.toggle("is-on", i === index);
      });
    }

    function render() {
      if (index > maxIndex()) index = 0;
      if (index < 0) index = maxIndex();
      if (fade) {
        slides.forEach(function (slide, i) {
          slide.classList.toggle("is-on", i === index);
        });
      } else {
        var view = perView();
        slides.forEach(function (slide) {
          slide.style.flex = "0 0 " + (100 / view) + "%";
        });
        track.style.transform = "translateX(-" + (index * (100 / view)) + "%)";
      }
      paintDots();
      var thumbs = document.querySelector('[data-thumbs="#' + root.id + '"]');
      if (thumbs) {
        Array.prototype.forEach.call(thumbs.children, function (thumb, i) {
          thumb.classList.toggle("is-on", i === index);
        });
      }
    }

    function go(next) {
      index = next;
      render();
    }

    root.addEventListener("click", function (event) {
      if (event.target.closest("[data-prev]")) go(index - 1);
      if (event.target.closest("[data-next]")) go(index + 1);
      var dot = event.target.closest("[data-go]");
      if (dot) go(Number(dot.dataset.go));
    });

    if (root.id) {
      var thumbs = document.querySelector('[data-thumbs="#' + root.id + '"]');
      if (thumbs) {
        thumbs.addEventListener("click", function (event) {
          var thumb = event.target.closest("button");
          if (!thumb) return;
          go(Array.prototype.indexOf.call(thumbs.children, thumb));
        });
      }
    }

    var delay = Number(root.dataset.autoplay || 0);
    if (delay) {
      root.addEventListener("mouseenter", function () { clearInterval(timer); });
      root.addEventListener("mouseleave", function () {
        timer = setInterval(function () { go(index + 1); }, delay);
      });
      timer = setInterval(function () { go(index + 1); }, delay);
    }

    window.addEventListener("resize", render);
    render();
  });

  var reveals = document.querySelectorAll("[data-reveal]");
  if (reveals.length) {
    var show = function (el) { el.classList.add("is-in"); };
    if (!("IntersectionObserver" in window)) {
      Array.prototype.forEach.call(reveals, show);
    } else {
      var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          show(entry.target);
          revealObserver.unobserve(entry.target);
        });
      }, { threshold: 0, rootMargin: "0px 0px -48px 0px" });
      Array.prototype.forEach.call(reveals, function (el) {
        revealObserver.observe(el);
      });
    }
  }

  var form = document.querySelector("[data-contact-form]");
  if (form) {
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      var note = form.querySelector(".form-note");
      var data = new FormData(form);
      var first = String(data.get("firstname") || "").trim();
      var last = String(data.get("lastname") || "").trim();
      var email = String(data.get("email") || "").trim();
      var phone = String(data.get("number") || "").trim();
      var message = String(data.get("message") || "").trim();
      if (!first || !last || !email || !phone || !message) {
        note.textContent = "Preencha todos os campos obrigatórios.";
        note.className = "form-note is-error";
        return;
      }
      var text = "Olá! Meu nome é " + first + " " + last +
        ". E-mail: " + email +
        ". Telefone: " + phone +
        ". Mensagem: " + message;
      window.open("https://wa.me/5571992645794?text=" + encodeURIComponent(text), "_blank", "noopener");
      note.textContent = "Abrimos o WhatsApp com a sua mensagem.";
      note.className = "form-note is-ok";
      form.reset();
    });
  }
})();

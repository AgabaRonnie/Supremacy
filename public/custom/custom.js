/* ============================================================
   SUPREMACY STUDIOS — Front-end JavaScript
============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ---------- Preloader (brand intro, once per session) ---------- */
  var preloader = document.getElementById('ssPreloader');
  if (preloader) {
    if (sessionStorage.getItem('ss_seen')) {
      preloader.classList.add('is-skipped');
    } else {
      sessionStorage.setItem('ss_seen', '1');
      setTimeout(function () { preloader.classList.add('is-done'); }, 1300);
    }
  }

  /* ---------- Navbar scroll state ---------- */
  var nav = document.getElementById('ssNav');
  function onScroll() {
    if (nav) nav.classList.toggle('is-scrolled', window.scrollY > 30);
  }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  /* ---------- Mobile menu ---------- */
  var toggle = document.getElementById('ssNavToggle');
  var menu = document.getElementById('ssMenu');
  if (toggle && menu) {
    toggle.addEventListener('click', function () {
      var open = menu.classList.toggle('is-open');
      toggle.classList.toggle('is-open', open);
      toggle.setAttribute('aria-expanded', open);
      menu.setAttribute('aria-hidden', !open);
      document.body.style.overflow = open ? 'hidden' : '';
    });
    menu.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () {
        menu.classList.remove('is-open');
        toggle.classList.remove('is-open');
        document.body.style.overflow = '';
      });
    });
  }

  /* ---------- Reveal on scroll ---------- */
  // Fail-open: shortly after the CSS transition should have finished, hard-set
  // the final state so content can never stay invisible on renderers where
  // CSS transitions stall.
  function forceVisible(el) {
    el.style.opacity = '1';
    el.style.transform = 'none';
  }

  var revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && revealEls.length) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          setTimeout(forceVisible.bind(null, entry.target), 1000);
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) {
      el.classList.add('is-visible');
      forceVisible(el);
    });
  }

  /* ---------- Hero background crossfade ---------- */
  var heroImgs = document.querySelectorAll('.ss-hero__bg img');
  function setActiveHero(imgs, idx) {
    imgs.forEach(function (im, i) {
      im.classList.toggle('is-active', i === idx);
      im.style.opacity = i === idx ? '1' : '0'; // fail-open if transitions stall
    });
  }
  if (heroImgs.length) {
    var current = 0;
    setActiveHero(heroImgs, 0);
    if (heroImgs.length > 1) {
      setInterval(function () {
        current = (current + 1) % heroImgs.length;
        setActiveHero(heroImgs, current);
      }, 6000);
    }
  }

  /* ---------- Artist section nav (scrollspy) ---------- */
  var asNav = document.getElementById('asNav');
  if (asNav) {
    var navLinks = Array.prototype.slice.call(asNav.querySelectorAll('a[href^="#"]'));
    var sections = navLinks
      .map(function (a) { return document.querySelector(a.getAttribute('href')); })
      .filter(Boolean);

    function updateSpy() {
      var offset = asNav.offsetHeight + 90;
      var active = sections[0];
      sections.forEach(function (sec) {
        if (sec.getBoundingClientRect().top <= offset) active = sec;
      });
      navLinks.forEach(function (a) {
        a.classList.toggle('is-active', a.getAttribute('href') === '#' + active.id);
      });
    }

    updateSpy();
    window.addEventListener('scroll', updateSpy, { passive: true });
  }

  /* ---------- Share buttons (artist pages etc.) ---------- */
  document.querySelectorAll('[data-share-url]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var url = btn.dataset.shareUrl;
      var title = btn.dataset.shareTitle || document.title;
      if (navigator.share) {
        navigator.share({ title: title, url: url }).catch(function () {});
      } else if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(function () {
          var original = btn.innerHTML;
          btn.innerHTML = '<i class="bi bi-check2 me-1"></i> Link copied';
          setTimeout(function () { btn.innerHTML = original; }, 2000);
        });
      }
    });
  });

});

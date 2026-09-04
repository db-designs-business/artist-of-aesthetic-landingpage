/* =========================================================
   Artist of Aesthetic — main.js
   ========================================================= */
(function () {
  'use strict';

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Jahr im Footer ---------- */
  var y = document.getElementById('year');
  if (y) y.textContent = new Date().getFullYear();

  /* ---------- Header: Schatten beim Scrollen ---------- */
  var header = document.getElementById('header');
  var onScroll = function () {
    header.classList.toggle('is-stuck', window.scrollY > 8);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- Mobile Navigation ---------- */
  var burger = document.getElementById('burger');
  var nav = document.getElementById('nav');
  var scrim = null;

  function closeNav() {
    if (!nav.classList.contains('is-open')) return;
    nav.classList.remove('is-open');
    burger.setAttribute('aria-expanded', 'false');
    burger.setAttribute('aria-label', 'Menü öffnen');
    document.body.classList.remove('nav-open');
    if (scrim) { scrim.remove(); scrim = null; }
    burger.focus();
  }

  function openNav() {
    nav.classList.add('is-open');
    burger.setAttribute('aria-expanded', 'true');
    burger.setAttribute('aria-label', 'Menü schließen');
    document.body.classList.add('nav-open');
    scrim = document.createElement('button');
    scrim.className = 'nav-scrim';
    scrim.type = 'button';
    scrim.setAttribute('aria-label', 'Menü schließen');
    scrim.addEventListener('click', closeNav);
    document.body.appendChild(scrim);
    var first = nav.querySelector('a');
    if (first) first.focus();
  }

  burger.addEventListener('click', function () {
    nav.classList.contains('is-open') ? closeNav() : openNav();
  });

  nav.addEventListener('click', function (e) {
    if (e.target.closest('a')) closeNav();
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeNav();
  });

  // Fokus im geöffneten Menü halten
  nav.addEventListener('keydown', function (e) {
    if (e.key !== 'Tab' || !nav.classList.contains('is-open')) return;
    var items = nav.querySelectorAll('a');
    var first = items[0];
    var last = items[items.length - 1];
    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
    else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
  });

  /* ---------- Reveal on Scroll ---------- */
  var reveals = document.querySelectorAll('.reveal');
  // Stagger-Index für Gruppen setzen
  ['.cards', '.usps', '.revs', '.steps', '.stats__grid'].forEach(function (sel) {
    var group = document.querySelector(sel);
    if (!group) return;
    Array.prototype.forEach.call(group.children, function (el, i) {
      el.style.setProperty('--i', i);
    });
  });

  if (reduced || !('IntersectionObserver' in window)) {
    Array.prototype.forEach.call(reveals, function (el) { el.classList.add('is-in'); });
  } else {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-in');
        io.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
    Array.prototype.forEach.call(reveals, function (el) { io.observe(el); });
  }

  /* ---------- Zähler-Animation ---------- */
  var counters = document.querySelectorAll('[data-count]');
  if (!reduced && 'IntersectionObserver' in window) {
    var cio = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        cio.unobserve(el);
        var target = parseInt(el.getAttribute('data-count'), 10);
        var suffix = el.getAttribute('data-suffix') || '';
        var start = performance.now();
        var dur = 1300;
        (function tick(now) {
          var p = Math.min((now - start) / dur, 1);
          var eased = 1 - Math.pow(1 - p, 3);
          el.textContent = Math.round(target * eased).toLocaleString('de-DE') + suffix;
          if (p < 1) requestAnimationFrame(tick);
        })(start);
      });
    }, { threshold: 0.5 });
    Array.prototype.forEach.call(counters, function (el) { cio.observe(el); });
  }

  /* ---------- Preis-Tabs ---------- */
  var tabList = document.querySelector('.tabs__list');
  if (tabList) {
    var tabs = Array.prototype.slice.call(tabList.querySelectorAll('[role="tab"]'));

    function selectTab(tab, setFocus) {
      tabs.forEach(function (t) {
        var selected = t === tab;
        t.setAttribute('aria-selected', String(selected));
        t.tabIndex = selected ? 0 : -1;
        t.classList.toggle('is-active', selected);
        document.getElementById(t.getAttribute('aria-controls')).hidden = !selected;
      });
      if (setFocus) tab.focus();
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () { selectTab(tab, false); });
      tab.addEventListener('keydown', function (e) {
        var i = tabs.indexOf(tab);
        var next = null;
        if (e.key === 'ArrowRight') next = tabs[(i + 1) % tabs.length];
        else if (e.key === 'ArrowLeft') next = tabs[(i - 1 + tabs.length) % tabs.length];
        else if (e.key === 'Home') next = tabs[0];
        else if (e.key === 'End') next = tabs[tabs.length - 1];
        if (next) { e.preventDefault(); selectTab(next, true); }
      });
    });
  }

  /* ---------- FAQ Accordion ---------- */
  Array.prototype.forEach.call(document.querySelectorAll('.faq__q'), function (btn) {
    btn.addEventListener('click', function () {
      var open = btn.getAttribute('aria-expanded') === 'true';
      var panel = document.getElementById(btn.getAttribute('aria-controls'));
      btn.setAttribute('aria-expanded', String(!open));
      panel.hidden = open;
    });
  });

  /* ---------- Aktiver Navigationspunkt ---------- */
  var sections = document.querySelectorAll('main section[id]');
  var navLinks = document.querySelectorAll('.nav a[href^="#"]');
  if ('IntersectionObserver' in window && sections.length) {
    var sio = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var id = entry.target.id;
        Array.prototype.forEach.call(navLinks, function (a) {
          a.classList.toggle('is-active', a.getAttribute('href') === '#' + id);
        });
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    Array.prototype.forEach.call(sections, function (s) { sio.observe(s); });
  }

  /* ---------- Formular ---------- */
  var form = document.getElementById('terminForm');
  if (!form) return;

  var summary = document.getElementById('formSummary');
  var summaryList = document.getElementById('formSummaryList');
  var success = document.getElementById('formSuccess');
  var submitBtn = document.getElementById('submitBtn');

  var labels = {
    name: 'Name',
    tel: 'Telefon',
    email: 'E-Mail',
    behandlung: 'Wunschbehandlung',
    datenschutz: 'Datenschutz'
  };

  var rules = {
    name: function (v) {
      if (!v.trim()) return 'Bitte gib deinen Namen an.';
      if (v.trim().length < 2) return 'Der Name ist zu kurz.';
      return '';
    },
    tel: function (v) {
      if (!v.trim()) return 'Bitte gib eine Telefonnummer an, damit ich dich erreichen kann.';
      if (v.replace(/[^0-9]/g, '').length < 7) return 'Diese Telefonnummer sieht unvollständig aus.';
      return '';
    },
    email: function (v) {
      if (!v.trim()) return '';
      if (!/^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i.test(v.trim())) return 'Bitte prüfe die E-Mail-Adresse, z. B. name@beispiel.de';
      return '';
    },
    behandlung: function (v) {
      if (!v) return 'Bitte wähle eine Wunschbehandlung aus.';
      return '';
    },
    datenschutz: function (v, el) {
      if (!el.checked) return 'Bitte stimme der Datenschutzerklärung zu.';
      return '';
    }
  };

  function setError(field, msg) {
    var el = document.getElementById(field);
    var box = document.getElementById('err-' + field);
    if (!el || !box) return;
    if (msg) {
      el.setAttribute('aria-invalid', 'true');
      box.textContent = msg;
      box.hidden = false;
    } else {
      el.removeAttribute('aria-invalid');
      box.textContent = '';
      box.hidden = true;
    }
  }

  function validateField(field) {
    var el = document.getElementById(field);
    var msg = rules[field](el.value, el);
    setError(field, msg);
    return msg;
  }

  // Validierung erst bei blur, danach live korrigierend
  Object.keys(rules).forEach(function (field) {
    var el = document.getElementById(field);
    if (!el) return;
    el.addEventListener('blur', function () { validateField(field); });
    el.addEventListener('change', function () {
      if (el.getAttribute('aria-invalid') === 'true') validateField(field);
    });
    el.addEventListener('input', function () {
      if (el.getAttribute('aria-invalid') === 'true') validateField(field);
    });
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    success.hidden = true;

    var errors = [];
    Object.keys(rules).forEach(function (field) {
      var msg = validateField(field);
      if (msg) {
        errors.push({ field: field, text: labels[field] + ': ' + msg });
      }
    });

    if (errors.length) {
      summaryList.innerHTML = '';
      errors.forEach(function (err) {
        var li = document.createElement('li');
        var a = document.createElement('a');
        a.href = '#' + err.field;
        a.textContent = err.text;
        a.addEventListener('click', function (ev) {
          ev.preventDefault();
          document.getElementById(err.field).focus();
        });
        li.appendChild(a);
        summaryList.appendChild(li);
      });
      summary.hidden = false;
      summary.focus();
      return;
    }

    summary.hidden = true;

    // Platzhalter für den Versand — hier später Backend/Formspree/CF7 anbinden.
    submitBtn.classList.add('is-loading');
    submitBtn.disabled = true;
    submitBtn.querySelector('.btn__label').textContent = 'Wird gesendet …';

    window.setTimeout(function () {
      submitBtn.classList.remove('is-loading');
      submitBtn.disabled = false;
      submitBtn.querySelector('.btn__label').textContent = 'Terminanfrage senden';
      form.reset();
      success.hidden = false;
      success.scrollIntoView({ block: 'nearest', behavior: reduced ? 'auto' : 'smooth' });
    }, 900);
  });
})();

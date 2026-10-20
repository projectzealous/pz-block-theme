/* Site header: mobile menu (burger) and tap-to-expand dropdowns. Desktop dropdowns are pure CSS hover/focus. */
(function () {
  function init(nav) {
    var burger = nav.querySelector('.burger');
    if (!burger || burger.dataset.smReady) return;
    burger.dataset.smReady = '1';
    var mq = window.matchMedia('(max-width: 860px)');

    function setOpen(open) {
      nav.classList.toggle('open', open);
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
      burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      burger.textContent = open ? '✕' : '☰';
      document.documentElement.classList.toggle('sm-navlock', open);
      if (!open) nav.querySelectorAll('.navitem.exp').forEach(function (i) { i.classList.remove('exp'); });
    }

    burger.addEventListener('click', function () { setOpen(!nav.classList.contains('open')); });

    nav.querySelectorAll('.navitem').forEach(function (item) {
      var link = item.querySelector('.navlink');
      if (!link || !item.querySelector('.dropdown')) return;
      link.addEventListener('click', function (e) {
        if (!nav.classList.contains('open')) return;
        if (!item.classList.contains('exp')) { e.preventDefault(); item.classList.add('exp'); }
      });
    });

    nav.addEventListener('click', function (e) {
      var a = e.target.closest('a');
      if (a && nav.classList.contains('open') && (a.getAttribute('href') || '').charAt(0) === '#') setOpen(false);
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && nav.classList.contains('open')) setOpen(false); });
    mq.addEventListener('change', function (e) { if (!e.matches) setOpen(false); });
  }
  function boot() { document.querySelectorAll('.sm-shared .nav').forEach(init); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot); else boot();
})();

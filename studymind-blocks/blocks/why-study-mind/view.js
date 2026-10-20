/* Why Study Mind: count-up stats when scrolled into view, and carousel arrows. */
(function () {
  function fmt(n, dec) { return n.toLocaleString('en-GB', { minimumFractionDigits: dec, maximumFractionDigits: dec }); }
  function init(sec) {
    if (sec.dataset.smReady) return;
    sec.dataset.smReady = '1';

    var nums = sec.querySelectorAll('[data-count]');
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (nums.length && !reduce && 'IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (!en.isIntersecting) return;
          io.unobserve(en.target);
          var el = en.target, to = parseFloat(el.dataset.count) || 0, dec = parseInt(el.dataset.dec || '0', 10), suf = el.dataset.suffix || '';
          var t0 = null, dur = 1400;
          function step(t) {
            if (!t0) t0 = t;
            var k = Math.min(1, (t - t0) / dur), e = 1 - Math.pow(1 - k, 3);
            el.textContent = fmt(to * e, dec) + suf;
            if (k < 1) requestAnimationFrame(step);
          }
          requestAnimationFrame(step);
        });
      }, { threshold: 0.4 });
      nums.forEach(function (n) { io.observe(n); });
    }

    var rail = sec.querySelector('.rail'), prev = sec.querySelector('.cbtn[aria-label="Previous"]'), next = sec.querySelector('.cbtn[aria-label="Next"]');
    if (!rail) return;
    function by(dir) {
      var card = rail.querySelector('.tcard');
      var w = card ? card.getBoundingClientRect().width + 16 : 296;
      rail.scrollBy({ left: dir * w, behavior: reduce ? 'auto' : 'smooth' });
    }
    if (prev) prev.addEventListener('click', function () { by(-1); });
    if (next) next.addEventListener('click', function () { by(1); });
  }
  function boot() { document.querySelectorAll('.sm-home .why').forEach(init); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot); else boot();
})();

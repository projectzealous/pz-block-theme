/* Products toolkit: product tabs swap the panel, as in the design. */
(function () {
  function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function init(sec) {
    var dataEl = sec.querySelector('.sm-toolkit-data');
    if (!dataEl || sec.dataset.smReady) return;
    sec.dataset.smReady = '1';
    var P; try { P = JSON.parse(dataEl.textContent); } catch (e) { return; }
    var tabs = sec.querySelectorAll('.prod');
    var title = sec.querySelector('#pTitle'), chips = sec.querySelector('#pChips'), badges = sec.querySelector('#pBadges');
    var cta = sec.querySelector('#pCta'), art = sec.querySelector('#pArt');
    P.forEach(function (p) { if (p.img) { var im = new Image(); im.src = p.img; } });

    function show(i) {
      var p = P[i]; if (!p) return;
      tabs.forEach(function (t, j) { t.setAttribute('aria-selected', i === j ? 'true' : 'false'); });
      title.textContent = p.title;
      chips.innerHTML = p.chips.map(function (c) { return '<span class="chip' + (c.wide ? ' wide' : '') + '"><i></i>' + esc(c.text) + '</span>'; }).join('');
      badges.innerHTML = p.badges.map(function (b) {
        return '<div class="tbadge">' + (b.img ? '<div class="ph light has-img"><img src="' + esc(b.img) + '" alt=""></div>' : '<div class="ph light" data-asset="badge"></div>') + '<span>' + esc(b.label) + '</span></div>';
      }).join('');
      cta.textContent = p.cta.title; cta.setAttribute('href', p.cta.url);
      if (p.cta.target) cta.setAttribute('target', p.cta.target); else cta.removeAttribute('target');
      art.src = p.img; art.alt = p.alt || p.title;
    }
    tabs.forEach(function (t, i) {
      t.addEventListener('click', function () { show(i); });
      t.addEventListener('keydown', function (e) {
        if (e.key !== 'ArrowDown' && e.key !== 'ArrowUp') return;
        e.preventDefault();
        var n = (i + (e.key === 'ArrowDown' ? 1 : -1) + tabs.length) % tabs.length;
        tabs[n].focus(); show(n);
      });
    });
  }
  function boot() { document.querySelectorAll('.sm-home .products').forEach(init); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot); else boot();
})();

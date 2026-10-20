/* Homepage hero: product finder (search tab + quiz tab). Data comes from the block's JSON script tag. */
(function () {
  function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function fmt(tpl, a, b) { return tpl.replace('%1$s', a).replace('%2$s', b); }

  function init(hero) {
    var finder = hero.querySelector('.finder');
    var dataEl = hero.querySelector('.sm-finder-data');
    if (!finder || !dataEl || finder.dataset.smReady) return;
    finder.dataset.smReady = '1';
    var D; try { D = JSON.parse(dataEl.textContent); } catch (e) { return; }
    var L = D.labels;

    /* Background video: respect reduced motion. */
    var video = hero.querySelector('.hero-video');
    if (video && window.matchMedia('(prefers-reduced-motion: reduce)').matches) { video.removeAttribute('autoplay'); video.pause && video.pause(); }

    /* Tabs */
    var tabs = finder.querySelectorAll('.finder-tabs [role="tab"]');
    var paneSearch = finder.querySelector('#paneSearch'), paneQuiz = finder.querySelector('#paneQuiz');
    tabs.forEach(function (t, i) {
      t.addEventListener('click', function () {
        tabs.forEach(function (x, j) { x.setAttribute('aria-selected', i === j ? 'true' : 'false'); });
        paneSearch.hidden = i !== 0; paneQuiz.hidden = i !== 1;
      });
    });

    /* Search */
    var input = finder.querySelector('#fq'), list = finder.querySelector('#fsug'), go = finder.querySelector('#fgo');
    var hits = [], hi = -1;
    function score(p, q) {
      var hay = (p.title + ' ' + p.desc + ' ' + p.kind + ' ' + p.keywords).toLowerCase();
      var words = q.toLowerCase().split(/\s+/).filter(Boolean), s = 0;
      for (var i = 0; i < words.length; i++) {
        if (hay.indexOf(words[i]) === -1) return 0;
        s += p.title.toLowerCase().indexOf(words[i]) !== -1 ? 3 : 1;
      }
      return s;
    }
    function renderList() {
      var q = input.value.trim();
      if (!q) { list.classList.remove('show'); list.innerHTML = ''; hits = []; return; }
      hits = D.products.map(function (p) { return { p: p, s: score(p, q) }; })
        .filter(function (x) { return x.s > 0; }).sort(function (a, b) { return b.s - a.s; })
        .slice(0, 6).map(function (x) { return x.p; });
      hi = hits.length ? 0 : -1;
      list.innerHTML = hits.length
        ? hits.map(function (p, i) { return '<li role="option" data-i="' + i + '"' + (i === hi ? ' class="hi"' : '') + '><div><b>' + esc(p.title) + '</b><span>' + esc(p.desc) + '</span></div>' + (p.kind ? '<span class="kind">' + esc(p.kind) + '</span>' : '') + '</li>'; }).join('')
        : '<li data-all="1"><div><b>' + esc(L.noResult) + '</b></div></li>';
      list.classList.add('show');
    }
    function goTo(i) {
      if (hits[i]) { window.location.href = hits[i].url; return; }
      var q = input.value.trim();
      window.location.href = q ? D.searchUrl + encodeURIComponent(q) : D.allUrl;
    }
    input.addEventListener('input', renderList);
    input.addEventListener('keydown', function (e) {
      var items = list.querySelectorAll('li[data-i]');
      if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
        if (!items.length) return;
        e.preventDefault();
        hi = (hi + (e.key === 'ArrowDown' ? 1 : -1) + items.length) % items.length;
        items.forEach(function (li, i) { li.classList.toggle('hi', i === hi); });
      } else if (e.key === 'Enter') { e.preventDefault(); goTo(hi); }
      else if (e.key === 'Escape') { list.classList.remove('show'); }
    });
    list.addEventListener('click', function (e) {
      var li = e.target.closest('li'); if (!li) return;
      if (li.dataset.all) { window.location.href = D.allUrl; return; }
      goTo(+li.dataset.i);
    });
    go.addEventListener('click', function () { goTo(hi); });

    /* Quiz */
    var steps = finder.querySelector('#qsteps'), bar = finder.querySelector('#qbar'), result = finder.querySelector('#qresult');
    var answers = [], n = D.quiz.length;
    function renderStep(i) {
      var q = D.quiz[i];
      bar.style.width = (i / n * 100) + '%';
      steps.hidden = false; result.classList.remove('on'); result.innerHTML = '';
      steps.innerHTML = '<div class="qstep on"><b>' + esc(q.q) + '</b><div class="qopts">' +
        q.options.map(function (o) { return '<button data-tag="' + esc(o.tag) + '">' + esc(o.label) + '</button>'; }).join('') +
        '</div><div class="qnav">' + (i ? '<button class="qback" type="button">' + esc(L.back) + '</button>' : '<span></span>') +
        '<span>' + esc(fmt(L.of, i + 1, n)) + '</span></div></div>';
    }
    function showResult() {
      bar.style.width = '100%';
      var ranked = D.products.map(function (p, idx) {
        var s = 0; answers.forEach(function (t) { if (t && p.tags.indexOf(t) !== -1) s++; });
        return { p: p, s: s, idx: idx };
      }).sort(function (a, b) { return b.s - a.s || a.idx - b.idx; });
      var pick = ranked[0] && ranked[0].p, alts = ranked.slice(1, 3).map(function (x) { return x.p; });
      if (!pick) return;
      steps.hidden = true;
      result.innerHTML = '<div class="pick"><span class="tagline">' + esc(L.pick) + '</span><b>' + esc(pick.title) + '</b><p>' + esc(pick.desc) + '</p><a class="btn" href="' + esc(pick.url) + '">' + esc(L.button) + '</a></div>' +
        (alts.length ? '<div class="alts">' + alts.map(function (a) { return '<a class="alt" href="' + esc(a.url) + '"><b>' + esc(a.title) + '</b><span>' + esc(a.kind || '') + ' →</span></a>'; }).join('') + '</div>' : '') +
        '<button class="restart" type="button">' + esc(L.restart) + '</button>';
      result.classList.add('on');
    }
    steps.addEventListener('click', function (e) {
      var back = e.target.closest('.qback');
      if (back) { answers.pop(); renderStep(answers.length); return; }
      var opt = e.target.closest('.qopts button'); if (!opt) return;
      answers.push(opt.dataset.tag);
      if (answers.length >= n) showResult(); else renderStep(answers.length);
    });
    result.addEventListener('click', function (e) {
      if (e.target.closest('.restart')) { answers = []; renderStep(0); }
    });
  }
  function boot() { document.querySelectorAll('.sm-home .hero').forEach(init); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot); else boot();
})();

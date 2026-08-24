/* Next Chapter — public site behaviour */

document.getElementById('yr').textContent = new Date().getFullYear();

// header shadow on scroll
const hdr = document.querySelector('header');
if (hdr) {
  addEventListener('scroll', () => hdr.classList.toggle('scrolled', scrollY > 10));
}

// mobile menu
const mb = document.getElementById('menuBtn');
const nl = document.getElementById('navlinks');
if (mb && nl) {
  mb.addEventListener('click', () => {
    const o = nl.classList.toggle('open');
    mb.setAttribute('aria-expanded', o);
  });
  nl.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
    nl.classList.remove('open');
    mb.setAttribute('aria-expanded', 'false');
  }));
}

// pricing toggle (individual / joint)
const toggle = document.getElementById('toggle');
const slide = document.getElementById('slide');
const tbtns = toggle ? [...toggle.querySelectorAll('button')] : [];

function positionSlide(btn) {
  slide.style.width = btn.offsetWidth + 'px';
  slide.style.transform = `translateX(${btn.offsetLeft - 5}px)`;
}

function setMode(mode) {
  tbtns.forEach(b => {
    const on = b.dataset.mode === mode;
    b.classList.toggle('active', on);
    b.setAttribute('aria-selected', on);
    if (on) positionSlide(b);
  });
  document.querySelectorAll('[data-ind]').forEach(el => {
    const v = mode === 'joint' ? el.dataset.joint : el.dataset.ind;
    if (el.textContent.trim().startsWith('£')) el.textContent = '£' + v;
    else el.textContent = v;
  });
}

tbtns.forEach(b => b.addEventListener('click', () => setMode(b.dataset.mode)));
addEventListener('load', () => { if (tbtns[0]) positionSlide(tbtns[0]); });
addEventListener('resize', () => {
  const a = toggle && toggle.querySelector('.active');
  if (a) positionSlide(a);
});

// FAQ accordion
document.querySelectorAll('.faq button').forEach(btn => {
  btn.addEventListener('click', () => {
    const item = btn.parentElement;
    const ans = item.querySelector('.ans');
    const open = item.classList.toggle('open');
    btn.setAttribute('aria-expanded', open);
    ans.style.maxHeight = open ? ans.scrollHeight + 'px' : 0;
  });
});

// demo video play
const dv = document.getElementById('demoVideo');
const dp = document.getElementById('demoPlay');
function playDemo() {
  dv.play();
  dp.style.display = 'none';
  dv.setAttribute('controls', '');
}
if (dv && dp) {
  dp.addEventListener('click', playDemo);
  dp.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); playDemo(); } });
}

/* Checkout buttons → POST /checkout-intent (Stripe integration point).
   Swap this handler for a fetch() to a Stripe Checkout Session endpoint
   once payment is connected; the route already records the interest. */
function currentMode() {
  return toggle.querySelector('.active').dataset.mode;
}

async function startCheckout(pkg, mode) {
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = document.body.dataset.checkoutUrl || '/checkout-intent';
  const csrf = document.querySelector('meta[name="csrf-token"]');
  const fields = {
    _token: csrf ? csrf.content : '',
    package: pkg,
    mode: mode,
  };
  Object.entries(fields).forEach(([k, v]) => {
    const i = document.createElement('input');
    i.type = 'hidden';
    i.name = k;
    i.value = v;
    form.appendChild(i);
  });
  document.body.appendChild(form);
  form.submit();
}

document.querySelectorAll('.buy').forEach(b => {
  b.addEventListener('click', () => startCheckout(b.dataset.package, currentMode()));
});

// tutorial video lightbox (uploaded tutorial videos)
const tlb = document.createElement('div');
tlb.className = 'tut-lightbox';
tlb.hidden = true;
tlb.innerHTML = '<div class="lb-back"></div><div class="lb-body"><button type="button" class="lb-close" aria-label="Close video">&times;</button><video controls playsinline></video></div>';
document.body.appendChild(tlb);
const tlbVideo = tlb.querySelector('video');

function closeTutorialVideo() {
  if (tlb.hidden) return;
  tlb.hidden = true;
  tlbVideo.pause();
  tlbVideo.removeAttribute('src');
  tlbVideo.load();
}

document.querySelectorAll('.tut[data-video-src]').forEach(card => {
  card.addEventListener('click', () => {
    tlbVideo.src = card.dataset.videoSrc;
    tlb.hidden = false;
    tlbVideo.play();
  });
});
tlb.querySelector('.lb-back').addEventListener('click', closeTutorialVideo);
tlb.querySelector('.lb-close').addEventListener('click', closeTutorialVideo);
addEventListener('keydown', e => { if (e.key === 'Escape') closeTutorialVideo(); });

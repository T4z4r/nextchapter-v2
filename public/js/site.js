/* Next Chapter - public site behaviour */

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

// Checkout buttons -> Stripe Checkout session API.
function currentMode() {
  return toggle.querySelector('.active').dataset.mode;
}

function showCheckoutMessage(message, type = 'err') {
  let banner = document.getElementById('checkoutFlash');
  const pricing = document.getElementById('pricing');
  if (!banner && pricing) {
    banner = document.createElement('div');
    banner.id = 'checkoutFlash';
    banner.className = 'flash-banner';
    pricing.querySelector('.wrap').prepend(banner);
  }
  if (banner) {
    banner.className = `flash-banner ${type}`;
    banner.textContent = message;
    banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
  } else {
    alert(message);
  }
}

async function startCheckout(pkg, mode) {
  const button = document.querySelector(`.buy[data-package="${pkg}"]`);
  if (button && button.dataset.checkoutPage) {
    window.location.href = `${button.dataset.checkoutPage}?billing_variant=${encodeURIComponent(mode)}`;
    return;
  }

  const email = prompt('Enter your email address to start secure checkout');
  if (!email) return;

  const response = await fetch(document.body.dataset.packagePurchaseUrl || '/api/packages/purchase', {
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      package_slug: pkg,
      billing_variant: mode,
      customer_email: email,
    }),
  });

  const payload = await response.json().catch(() => ({}));

  if (!response.ok) {
    showCheckoutMessage(payload.message || 'Checkout could not be started. Please try again.');
    return;
  }

  if (payload.url) {
    window.location.href = payload.url;
    return;
  }

  showCheckoutMessage('Checkout started, but Stripe did not return a redirect URL. Please contact us.');
}

document.querySelectorAll('.buy').forEach(b => {
  b.addEventListener('click', async () => {
    const original = b.textContent;
    b.disabled = true;
    b.textContent = 'Starting checkout...';
    try {
      await startCheckout(b.dataset.package, currentMode());
    } catch (e) {
      showCheckoutMessage('Checkout could not be started. Please check your connection and try again.');
    } finally {
      b.disabled = false;
      b.textContent = original;
    }
  });
});

// Checkout option page
const checkoutPage = document.querySelector('.checkout-page');
const checkoutForm = document.getElementById('checkoutForm');
if (checkoutPage && checkoutForm) {
  const amount = document.getElementById('checkoutAmount');
  const sub = document.getElementById('checkoutSub');
  const message = document.getElementById('checkoutMessage');
  const featureLines = [...document.querySelectorAll('.checkout-features [data-ind]')];

  function setCheckoutMode(mode) {
    amount.textContent = mode === 'joint' ? amount.dataset.joint : amount.dataset.ind;
    sub.textContent = mode === 'joint' ? sub.dataset.joint : sub.dataset.ind;
    featureLines.forEach(line => {
      line.textContent = mode === 'joint' ? line.dataset.joint : line.dataset.ind;
    });
  }

  checkoutForm.querySelectorAll('input[name="billing_variant"]').forEach(input => {
    input.addEventListener('change', () => setCheckoutMode(input.value));
  });

  function showCheckoutPageError(text) {
    message.hidden = false;
    message.textContent = text;
  }

  checkoutForm.addEventListener('submit', async e => {
    e.preventDefault();
    message.hidden = true;

    const submit = checkoutForm.querySelector('button[type="submit"]');
    const original = submit.textContent;
    submit.disabled = true;
    submit.textContent = 'Starting checkout...';

    try {
      const formData = new FormData(checkoutForm);
      const response = await fetch(checkoutPage.dataset.purchaseUrl || '/api/packages/purchase', {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          package_slug: checkoutPage.dataset.packageSlug,
          billing_variant: formData.get('billing_variant'),
          customer_email: formData.get('customer_email'),
        }),
      });

      const payload = await response.json().catch(() => ({}));
      if (!response.ok) {
        showCheckoutPageError(payload.message || 'Checkout could not be started. Please try again.');
        return;
      }

      if (payload.url) {
        window.location.href = payload.url;
        return;
      }

      showCheckoutPageError('Checkout started, but Stripe did not return a redirect URL. Please contact us.');
    } catch (e) {
      showCheckoutPageError('Checkout could not be started. Please check your connection and try again.');
    } finally {
      submit.disabled = false;
      submit.textContent = original;
    }
  });
}

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

// Register Service Worker
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js')
      .then((reg) => console.log('Zity PWA Service Worker Registered:', reg.scope))
      .catch((err) => console.log('Service Worker Registration Failed:', err));
  });
}

// Handle PWA Install Prompt
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  deferredPrompt = e;
  
  // Show any PWA install banner if exists
  const installBanner = document.getElementById('pwa-install-banner');
  if (installBanner) {
    installBanner.classList.remove('hidden');
  }
  const installButtons = document.querySelectorAll('.pwa-install-btn');
  installButtons.forEach(btn => btn.classList.remove('hidden'));
});

window.installZityApp = function() {
  if (deferredPrompt) {
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then((choiceResult) => {
      if (choiceResult.outcome === 'accepted') {
        console.log('User accepted the Zity app install');
      }
      deferredPrompt = null;
      const installBanner = document.getElementById('pwa-install-banner');
      if (installBanner) installBanner.classList.add('hidden');
    });
  } else {
    alert('To install Zity App: Tap "Add to Home Screen" or the install icon in your browser address bar!');
  }
};

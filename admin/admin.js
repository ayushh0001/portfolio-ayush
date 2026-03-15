// Tab switching with URL hash persistence
const tabLinks = document.querySelectorAll('.admin-nav-link[data-tab]');
const tabs     = document.querySelectorAll('.admin-tab');

function activateTab(tabName) {
  tabs.forEach(t => t.classList.add('hidden'));
  tabLinks.forEach(l => l.classList.remove('active'));

  const target = document.getElementById('tab-' + tabName);
  const link   = document.querySelector(`.admin-nav-link[data-tab="${tabName}"]`);

  if (target) target.classList.remove('hidden');
  if (link)   link.classList.add('active');
}

tabLinks.forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const tab = link.dataset.tab;
    activateTab(tab);
    history.replaceState(null, '', '#' + tab);
  });
});

// File input label feedback
document.querySelectorAll('input[type="file"]').forEach(input => {
  input.addEventListener('change', () => {
    const label = document.querySelector('label[for="' + input.id + '"]');
    if (!label) return;
    const nameEl = label.querySelector('.file-label-name');
    if (input.files && input.files[0]) {
      label.classList.add('selected');
      if (nameEl) nameEl.textContent = input.files[0].name;
    } else {
      label.classList.remove('selected');
      if (nameEl) nameEl.textContent = 'No file chosen';
    }
  });
});

// Restore active tab from URL hash on load
const hash = window.location.hash.replace('#', '');
const validTabs = ['profile', 'projects', 'skills'];
activateTab(validTabs.includes(hash) ? hash : 'profile');


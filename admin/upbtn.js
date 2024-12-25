// Select the button
const goUpBtn = document.getElementById('goUpBtn');

// Show button when scrolled down
window.addEventListener('scroll', () => {
  if (window.scrollY > 200) {
    goUpBtn.style.display = 'flex';
  } else {
    goUpBtn.style.display = 'none';
  }
});

// Scroll to top when button is clicked
goUpBtn.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});

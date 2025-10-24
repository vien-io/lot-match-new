document.addEventListener("DOMContentLoaded", () => {
  const col = document.querySelector(".smooth-follow");
  if (!col) return;

  let targetY = 0;
  let currentY = 0;
  const ease = 0.1; 

  function animate() {
    const diff = targetY - currentY;
    currentY += diff * ease;
    col.style.transform = `translateY(${currentY}px)`;
    requestAnimationFrame(animate);
  }

  window.addEventListener("scroll", () => {
    targetY = window.scrollY + 24; 
  });

  animate();
});
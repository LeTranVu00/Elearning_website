/* ============================================
   LEARNCODE - MAIN APPLICATION FILE (MVC LITE)
   ============================================ */

/* ============================================
   ATTACH EVENT LISTENERS
   ============================================ */
document.addEventListener("DOMContentLoaded", () => {
  // ========== PASSWORD TOGGLE ==========
  const toggleButtons = document.querySelectorAll('[data-action="toggle-password"]');
  toggleButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = button.getAttribute("data-target");
      const targetInput = document.getElementById(targetId);

      if (targetInput) {
        const isPassword = targetInput.type === "password";
        targetInput.type = isPassword ? "text" : "password";

        const icon = button.querySelector("i");
        if (icon) {
          icon.classList.toggle("fa-eye");
          icon.classList.toggle("fa-eye-slash");
        }
      }
    });
  });

  // ========== COURSE CATEGORY FILTER ==========
  const categoryButtons = document.querySelectorAll(
    '[data-action="course-filter-category"]'
  );
  categoryButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      const category = button.getAttribute("data-value");
      updateCourseFilter(category, categoryButtons);
    });
  });

  // ========== SMOOTH SCROLL ==========
  const scrollLinks = document.querySelectorAll('a[href^="#"]');
  scrollLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      const href = link.getAttribute("href");
      if (href !== "#") {
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
          target.scrollIntoView({ behavior: "smooth" });
        }
      }
    });
  });
});

function updateCourseFilter(category, buttons) {
  buttons.forEach((btn) => {
    if (btn.getAttribute("data-value") === category) {
      btn.classList.remove("bg-slate-100", "text-slate-700", "hover:bg-slate-100");
      btn.classList.add("bg-primary", "text-white");
    } else {
      btn.classList.remove("bg-primary", "text-white");
      btn.classList.add("bg-slate-100", "text-slate-700", "hover:bg-slate-100");
    }
  });
  console.log('Filtering courses by category: ' + category);
}
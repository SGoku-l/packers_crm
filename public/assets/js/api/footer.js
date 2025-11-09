document.addEventListener("DOMContentLoaded", function() {
                const html = document.documentElement;
                const toggle = document.getElementById("light-dark-mode");
                const STORAGE_KEY = "data-bs-theme";

                if (!toggle) return console.warn("Dark mode toggle not found.");

                // Restore theme from localStorage or default to light
                const saved = localStorage.getItem(STORAGE_KEY) || "light";
                html.setAttribute("data-bs-theme", saved);

                // Update icon visibility
                const updateIcons = () => {
                    const isDark = html.getAttribute("data-bs-theme") === "dark";
                    document.querySelector(".iconoir-half-moon").style.display = isDark ? "none" : "inline-block";
                    document.querySelector(".iconoir-sun-light").style.display = isDark ? "inline-block" : "none";
                };
                updateIcons();

                // Remove app.js listener (to avoid conflict)
                const newToggle = toggle.cloneNode(true);
                toggle.parentNode.replaceChild(newToggle, toggle);

                // Add our own persistent toggle
                newToggle.addEventListener("click", (e) => {
                    e.preventDefault();
                    const current = html.getAttribute("data-bs-theme");
                    const next = current === "dark" ? "light" : "dark";
                    html.setAttribute("data-bs-theme", next);
                    localStorage.setItem(STORAGE_KEY, next);
                    updateIcons();
                });
            });
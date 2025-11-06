import "./bootstrap";

// ===== Chart.js
import Chart from "chart.js/auto";
import "chartjs-adapter-date-fns";

// ===== Swiper (bundle biar simple)
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

import AOS from "aos";
import "aos/dist/aos.css";

function initAOS() {
    try {
        if (!window.__aosInited) {
            AOS.init({
                duration: 800,
                easing: "ease-out-cubic",
                once: true,
                offset: 0, // 🔑 dari 80 → 0
                mirror: false,
                startEvent: "load", // 🔑 nunggu semua asset siap
            });
            window.__aosInited = true;
        } else {
            AOS.refreshHard();
        }
    } catch (e) {
        console.error("AOS init failed:", e);
    }
}

// ===== util: destroy chart kalau sudah ada
function makeOrUpdateChart(el, config) {
    const existing = Chart.getChart(el);
    if (existing) existing.destroy();
    return new Chart(el, config);
}

// ===== CHARTS
window.renderCharts = () => {
    const lineEl = document.getElementById("chartLine");
    const donutEl = document.getElementById("chartDonut");

    // LINE
    if (lineEl?.dataset.labels && lineEl?.dataset.values) {
        const labels = JSON.parse(lineEl.dataset.labels);
        const values = JSON.parse(lineEl.dataset.values);

        makeOrUpdateChart(lineEl, {
            type: "line",
            data: {
                labels,
                datasets: [
                    {
                        label: "Published",
                        data: values,
                        borderWidth: 2,
                        tension: 0.3,
                        fill: false,
                    },
                ],
            },
            options: {
                parsing: false,
                scales: {
                    x: { type: "category" },
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                },
                plugins: { legend: { display: false } },
            },
        });
    }

    // DOUGHNUT
    if (donutEl?.dataset.labels && donutEl?.dataset.values) {
        const labels = JSON.parse(donutEl.dataset.labels);
        const values = JSON.parse(donutEl.dataset.values);

        makeOrUpdateChart(donutEl, {
            type: "doughnut",
            data: { labels, datasets: [{ data: values }] },
            options: {
                cutout: "60%",
                plugins: { legend: { position: "bottom" } },
            },
        });
    }
};

// ===== NEWS SWIPER
window.initNewsSwiper = () => {
    const el = document.querySelector(".news-swiper");
    if (!el) return;

    // Hapus instance lama (HMR/Livewire)
    if (el._swiper) el._swiper.destroy(true, true);

    el._swiper = new Swiper(el, {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 16,
        loop: false,
        rewind: true, // balik ke awal setelah slide terakhir
        loopFillGroupWithBlank: true, // biar grup pas walau item nggak kelipatan
        pagination: { el: ".news-pagination", clickable: true },
        navigation: { nextEl: ".news-next", prevEl: ".news-prev" },
        breakpoints: {
            640: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 20 },
            1024: { slidesPerView: 3, slidesPerGroup: 3, spaceBetween: 24 },
        },
    });
};

// ===== FAQ Accordion: single-open + smooth height animation
window.initFaqAccordion = () => {
    const root = document.querySelector("#faq-accordion");
    if (!root) return;

    const triggers = [...root.querySelectorAll(".faq-trigger")];
    let open = null; // currently open panel

    const openPanel = (btn, panel) => {
        btn.setAttribute("aria-expanded", "true");
        btn.querySelector(".chev")?.classList.add("rotate-180");

        // animate to auto height
        panel.style.height = "0px";
        panel.classList.remove("hidden");
        const h = panel.scrollHeight;
        panel.style.height = h + "px";
        panel.addEventListener("transitionend", function onEnd() {
            panel.style.height = "auto";
            panel.removeEventListener("transitionend", onEnd);
        });
        open = { btn, panel };
    };

    const closePanel = ({ btn, panel }) => {
        btn.setAttribute("aria-expanded", "false");
        btn.querySelector(".chev")?.classList.remove("rotate-180");

        // from auto -> fixed -> 0 for smooth collapse
        panel.style.height = panel.scrollHeight + "px";
        requestAnimationFrame(() => {
            panel.style.height = "0px";
        });
        panel.addEventListener("transitionend", function onEnd() {
            panel.classList.remove("hidden"); // keep space none while height=0
            panel.removeEventListener("transitionend", onEnd);
        });
        open = null;
    };

    triggers.forEach((btn) => {
        const panel = root.querySelector(btn.dataset.target);
        // ensure start state
        panel.style.height = "0px";
        btn.setAttribute("aria-expanded", "false");

        btn.addEventListener("click", () => {
            // if clicking currently open -> close
            if (open && open.panel === panel) {
                closePanel(open);
                return;
            }
            // close previous
            if (open) closePanel(open);
            // open current
            openPanel(btn, panel);
        });
    });
};

// ===== Counter (0 -> target) saat terlihat
function animateCounter(el) {
    if (el.dataset._countDone === "1") return;

    const target = parseInt(el.dataset.target || "0", 10);
    const duration = parseInt(el.dataset.duration || "1200", 10);
    const fmt = new Intl.NumberFormat("id-ID");
    const start = performance.now();

    const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

    function frame(now) {
        const elapsed = now - start;
        const p = Math.min(1, elapsed / duration);
        const eased = easeOutCubic(p);
        const val = Math.round(target * eased);
        el.textContent = fmt.format(val);
        if (p < 1) {
            requestAnimationFrame(frame);
        } else {
            el.textContent = fmt.format(target); // snap ke target pas akhir
            el.dataset._countDone = "1";
        }
    }
    requestAnimationFrame(frame);
}

window.initCountersOnView = () => {
    const counters = document.querySelectorAll(".counter");
    if (!counters.length) return;

    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (!e.isIntersecting) return;
                animateCounter(e.target);
                io.unobserve(e.target); // sekali saja
            });
        },
        { threshold: 0.3 }
    );

    counters.forEach((c) => io.observe(c));
};

document.addEventListener(
    "DOMContentLoaded",
    () => {
        initAOS();
        window.renderCharts();
        window.initNewsSwiper();
        window.initFaqAccordion();
        window.initCountersOnView();
    },
    { once: true }
);

window.addEventListener("load", () => {
    initAOS(); // in case belum
    AOS.refreshHard(); // pastikan posisi recalculated setelah gambar kebuka
});

document.addEventListener("livewire:navigated", () => {
    window.renderCharts();
    window.initNewsSwiper();
    window.initFaqAccordion();
    window.initCountersOnView();
    AOS.refreshHard();
});

document.addEventListener("livewire:update", () => {
    window.renderCharts();
    window.initNewsSwiper();
    window.initFaqAccordion();
    window.initCountersOnView();
    AOS.refreshHard();
});

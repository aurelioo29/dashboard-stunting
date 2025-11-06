import "./bootstrap";

// Auto bundle: semua controllers/scales/elements ke-register
import Chart from "chart.js/auto";
import "chartjs-adapter-date-fns";

// Destroy jika sudah ada chart di elemen tsb
function makeOrUpdateChart(el, config) {
    const existing = Chart.getChart(el);
    if (existing) existing.destroy();
    return new Chart(el, config);
}

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
                    x: { type: "category" }, // label "06 Nov", dst.
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                },
                plugins: { legend: { display: false } },
            },
        });
    }

    // DONUT
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

// Render awal & ulang kalau Livewire ganti DOM
document.addEventListener("DOMContentLoaded", () => window.renderCharts(), {
    once: true,
});
document.addEventListener("livewire:navigated", () => window.renderCharts());
document.addEventListener("livewire:update", () => window.renderCharts());

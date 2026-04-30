import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

async function toggleFavorito(idMeal, btn) {
    try {
        const res = await fetch("/favoritos/toggle", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ idMeal }),
        });

        const data = await res.json();

        if (data.status === "added") {
            btn.textContent = "Quitar";
        } else if (data.status === "removed") {
            btn.textContent = "Añadir";
        }
    } catch (e) {
        console.error(e);
    }
}

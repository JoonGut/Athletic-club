async function obtenerEquiposLiga() {
    const codCompeticion = "PD"; // Código de LaLiga
    const token = import.meta.env.VITE_FOOTBALL_DATA_TOKEN;
    const url = `https://api.football-data.org/v4/competitions/${codCompeticion}`;
    const contenedor = document.getElementById("football-data");

    if (!contenedor) {
        return;
    }

    try {
        const respuesta = await fetch(url, {
            headers: {
                "X-Auth-Token": token,
            },
        });

        if (!respuesta.ok) {
            throw new Error(`Error ${respuesta.status}: No se pudo conectar con football-data.org`);
        }

        const datos = await respuesta.json();

        contenedor.innerHTML = `
            <div class="competition-card">
                ${datos.emblem ? `<img src="${datos.emblem}" alt="Emblema de ${datos.name}">` : ""}
                <h2>${datos.name}</h2>
                <p>Código: ${datos.code || codCompeticion}</p>
                <p>País: ${datos.area?.name || "No disponible"}</p>
                <p>Última actualización: ${datos.lastUpdated || "No disponible"}</p>
            </div>
        `;
    } catch (error) {
        console.error("Error en la API de football-data.org:", error);
        contenedor.innerHTML = `<p>Error al cargar la información de la competición. Revisa la consola.</p>`;
    }
}

obtenerEquiposLiga();
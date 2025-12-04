$(document).ready(function () {
    // Données PHP injectées dans JS (déjà calculées côté PHP)
    const dataSQL = <?php echo json_encode($data); ?>;
    const labels = dataSQL.map(d => d.categorie);
    const values = dataSQL.map(d => d.likes);

    // sécurité : éviter -Infinity si toutes les valeurs sont à 0
    const maxLikes = values.length ? Math.max(...values) || 1 : 1;

    const canvas = document.getElementById("radar");
    const wrapper = canvas.parentElement;
    const ctx = canvas.getContext("2d");

    // Fonction qui gère le resize + redraw
    function resizeAndDraw(){
    const size = Math.min(wrapper.clientWidth, wrapper.clientHeight);
    const dpr = window.devicePixelRatio || 1;

    canvas.width = size * dpr;
    canvas.height = size * dpr;
    canvas.style.width = size + "px";
    canvas.style.height = size + "px";
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

    const cx = size / 2;
    const cy = size / 2;
    const radius = size * 0.35; // bien centré avec marge

    drawRadar(ctx, cx, cy, radius, labels, values, maxLikes, size);
    }

    // Offset dynamique des labels
    function sizeLabelOffset(radius){
    return Math.max(6, radius * 0.1);
    }

    // Fonction pour écrire du texte sur plusieurs lignes
    function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
    const words = text.split(" ");
    let line = "";
    let offsetY = 0;

    for (let i = 0; i < words.length; i++) {
        const testLine = line + words[i] + " ";
        const testWidth = ctx.measureText(testLine).width;

        if (testWidth > maxWidth && i > 0) {
        ctx.fillText(line, x, y + offsetY);
        line = words[i] + " ";
        offsetY += lineHeight;
        } else {
        line = testLine;
        }
    }
    ctx.fillText(line, x, y + offsetY);
    }

    // Fonction principale de dessin du radar
    function drawRadar(ctx, cx, cy, radius, labels, values, maxLikes, size){
    const total = labels.length;
    ctx.clearRect(0, 0, size, size);

    // === GRILLE ===
    ctx.strokeStyle = "#ddd";
    ctx.lineWidth = 1;
    for (let level = 1; level <= 5; level++) {
        const r = radius * (level / 5);
        ctx.beginPath();
        for (let i = 0; i < total; i++) {
        const angle = (2 * Math.PI / total) * i - Math.PI/2;
        const x = cx + Math.cos(angle) * r;
        const y = cy + Math.sin(angle) * r;
        i === 0 ? ctx.moveTo(x,y) : ctx.lineTo(x,y);
        }
        ctx.closePath();
        ctx.stroke();
    }

    // === AXES + LABELS ===
    ctx.strokeStyle = "#aaa";
    ctx.fillStyle = "#000";

    labels.forEach((label, i) => {
        const angle = (2 * Math.PI / total) * i - Math.PI / 2;
        const x = cx + Math.cos(angle) * radius;
        const y = cy + Math.sin(angle) * radius;
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.lineTo(x, y);
        ctx.stroke();

        const lx = cx + Math.cos(angle) * (radius + sizeLabelOffset(radius));
        const ly = cy + Math.sin(angle) * (radius + sizeLabelOffset(radius));

        // === Gestion de la taille de police selon longueur ===
        let fontSize = Math.max(9, Math.round(size * 0.03));
        if (label.length >= 10) fontSize *= 0.9;

        ctx.font = fontSize + "px Arial";
        const maxWidth = size * 0.22;
        const lineHeight = fontSize + 2;
        
        ctx.textAlign = Math.cos(angle) > 0.15 ? "left" : Math.cos(angle) < -0.15 ? "right" : "center";

        wrapText(ctx, label, lx, ly - fontSize/2, maxWidth, lineHeight);
    });

    // === DONNÉES POLYGONE ===
    ctx.beginPath();
    ctx.fillStyle = "rgba(0,150,255,0.25)";
    ctx.strokeStyle = "#0096FF";
    ctx.lineWidth = Math.max(1.5, Math.round(size * 0.006));

    for (let i = 0; i < total; i++) {
        const v = values[i] / maxLikes;
        const angle = (2 * Math.PI / total) * i - Math.PI/2;
        const x = cx + Math.cos(angle) * radius * v;
        const y = cy + Math.sin(angle) * radius * v;
        i === 0 ? ctx.moveTo(x,y) : ctx.lineTo(x,y);
    }

    ctx.closePath();
    ctx.fill();
    ctx.stroke();
    }

    // Observer pour redessiner si le div change (responsive)
    const ro = new ResizeObserver(() => resizeAndDraw());
    ro.observe(wrapper);

    // Render au chargement et resize
    window.addEventListener('load', resizeAndDraw);
    window.addEventListener('resize', resizeAndDraw);
});
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title>Préférences utilisateur — Radar</title>
<style>
  body{ font-family: Arial, sans-serif; padding:40px; text-align:center; }
  canvas{ margin:auto; display:block; }
</style>
</head>
<body>

<h2>📊 Préférences de l'utilisateur</h2>
<canvas id="radar" width="600" height="600"></canvas>

<script>
// ==================
// Données utilisateur simulées provenant de SQL
// ==================
// Normalement issues de : SELECT categorie, nb_likes FROM user_game_likes WHERE id_user = X;

const dataSQL = [
  { categorie: "Co-op",             likes: 12 },
  { categorie: "MMO",               likes: 20 },
  { categorie: "Mods",               likes: 8 },
  { categorie: "Multi-player",       likes: 15 },
  { categorie: "PvP",                likes: 10 },
  { categorie: "Remote Play",        likes: 5 },
  { categorie: "Shared/Split Screen",likes: 7 },
  { categorie: "Controller support", likes: 9 },
  { categorie: "VR",                 likes: 6 }
];

const labels = dataSQL.map(d => d.categorie);
const values = dataSQL.map(d => d.likes);

const maxLikes = Math.max(...values);

const canvas = document.getElementById("radar");
const ctx = canvas.getContext("2d");

const cx = canvas.width / 2;
const cy = canvas.height / 2;
const radius = 250;
const total = labels.length;

// Dessiner la grille
function drawGrid(){
  ctx.clearRect(0,0,canvas.width,canvas.height);

  ctx.strokeStyle = "#ddd";
  ctx.lineWidth = 1;

  for(let level=1; level<=5; level++){
    const r = radius * (level/5);
    ctx.beginPath();
    for(let i=0; i<total; i++){
      const angle = (2*Math.PI/total) * i - Math.PI/2;
      const x = cx + Math.cos(angle) * r;
      const y = cy + Math.sin(angle) * r;
      (i===0) ? ctx.moveTo(x,y) : ctx.lineTo(x,y);
    }
    ctx.closePath();
    ctx.stroke();
  }

  // axes + labels
  ctx.strokeStyle = "#aaa";
  ctx.fillStyle = "#000";
  ctx.font = "14px Arial";

  labels.forEach((label, i) => {
    const angle = (2*Math.PI/total) * i - Math.PI/2;
    const x = cx + Math.cos(angle) * radius;
    const y = cy + Math.sin(angle) * radius;
    ctx.beginPath();
    ctx.moveTo(cx,cy);
    ctx.lineTo(x,y);
    ctx.stroke();

    const lx = cx + Math.cos(angle) * (radius + 20);
    const ly = cy + Math.sin(angle) * (radius + 20);
    ctx.textAlign = Math.cos(angle) > 0.1 ? "left" : Math.cos(angle) < -0.1 ? "right" : "center";
    ctx.fillText(label, lx, ly);
  });
}

// Dessiner les données
function drawData(){
  ctx.beginPath();
  ctx.fillStyle = "rgba(0,150,255,0.2)";
  ctx.strokeStyle = "#0096FF";
  ctx.lineWidth = 2;

  for(let i=0; i<total; i++){
    const v = values[i] / maxLikes;
    const angle = (2*Math.PI/total) * i - Math.PI/2;
    const x = cx + Math.cos(angle) * radius * v;
    const y = cy + Math.sin(angle) * radius * v;
    if(i===0) ctx.moveTo(x,y); else ctx.lineTo(x,y);
  }

  ctx.closePath();
  ctx.fill();
  ctx.stroke();
}

drawGrid();
drawData();
</script>

</body>
</html>

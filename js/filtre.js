$(document).ready(function() {

    sidebar = $("#sidebar_filtres");
    overlay = $("#overlay_filtres");

    // Ouvre quand on clique sur le bouton
    $(".filtres").on("click", function() {
        sidebar.addClass("active");
        overlay.addClass("active");
        $(".filtres").addClass("active");
    });

    // Ferme quand on clique ailleurs
    overlay.on("click", function() {
        sidebar.removeClass("active");
        overlay.removeClass("active");
        $(".filtres").removeClass("active");
    });

});
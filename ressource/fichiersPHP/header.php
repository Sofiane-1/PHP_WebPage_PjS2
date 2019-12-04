<?php
    $p = include './ressource/fichiersPHP/connexion.php';


    $header = <<<HTML
<!--- Titre --->
  	<div class="d-flex flex-row">
  	    <div class="d-flex justify-content-center align-items-start w-100">
        <img src="./ressource/img/favicon.png" alt="" width="200" height="200">
        </div>
        <div style="position: absolute; top:4px; right: 17px;">$p</div>
  	</div>


    <div class="border border-dark">
        <ul class="nav bg-warning" id="menu">
           <li class="nav-items">
                <a class="nav-link active text-white" href="./index.php">Accueil</a>
            </li>
            <li class="nav-items">
                <a class="nav-link active text-white" href="./nosPizzas.php">Nos Pizzas</a>
            </li>

            <li class="nav-items">
                <a class="nav-link active text-white" href="./contact.php">Contact</a>
            </li>
            
        </ul>
    
    </div>
    <script>
    var positionElementInPage = $('#menu').offset().top;
    $( window ).resize(function() {
        positionElementInPage = $('#menu').offset().top;
    });
    $(window).scroll(
        function() {
            if ($(window).scrollTop() > positionElementInPage) {
                // fixed
                $('#menu').addClass("fixedTop");
            } else {
                // unfixed
                $('#menu').removeClass("fixedTop");
            }
        }
    
    );
    </script>
HTML;




return $header;

<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _tw
 */

$locations = get_nav_menu_locations(); 
$menu_id = $locations['menu-1'];
$menu = wp_get_nav_menu_object($menu_id);
$menu_logo = get_field('logo', $menu); // Récupérer le champ ACF 'logo' pour ce menu


$menu_items = wp_get_nav_menu_items('menu');
$menu_data = []; // Variable pour stocker les informations du menu

if ($menu_items) {
    // Organiser les éléments en fonction de leur relation parent-enfant
    foreach ($menu_items as $item) {
        if (!$item->menu_item_parent) {
            // Élément de premier niveau
            $menu_data[$item->ID] = [
                'title' => $item->title,
                'url' => $item->url,
                'children' => []
            ];
        } else {
            // Élément de sous-menu
            $menu_data[$item->menu_item_parent]['children'][] = [
                'title' => $item->title,
                'url' => $item->url
            ];
        }
    }
}
?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<header id="masthead" class="bg-white text-black">
    <div class="flex flex-col justify-between">
        <div class="flex justify-between">
            <a href="<?php echo home_url(); ?>" class="w-64 h-auto max-mid-xl:w-56">
                <img src="<?php echo $menu_logo['url']; ?>">
            </a>

            <!-- Menu Classique -->
            <nav class="max-xl:hidden p-8 place-self-center max-mid-xl:text-sm 2xl:text-lg">
                <ul class="flex gap-4 font-bold">
                    <?php foreach ($menu_data as $item): ?>
                        <?php if (!empty($item['children'])): ?>
                            <li class="relative menu-item-has-children">
                                <a class="hover:text-secondary" href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
                                <ul class="sub-menu bg-black">
                                    <?php foreach ($item['children'] as $child): ?>
                                        <li class="p-4 hover:font-bold"><a class="hover:text-secondary" href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['title']); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>  
                            <?php if ($item['title'] != 'Nous contacter'): ?>
                            <li class="relative hover:bg-gray-600 lg:hover:bg-transparent">
                                <a class="hover:text-secondary" href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
                            </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <div class="flex gap-4 font-bold m-8 p-2 place-self-center border-solid border-2 border-stone-400 hover:text-secondary max-xl:hidden max-mid-xl:text-sm 2xl:text-lg">
                <?php
                // Filtrer pour obtenir l'item 'Nous contacter' dans le menu
                $contact_item = array_filter($menu_data, function($item) {
                    return $item['title'] === 'Nous contacter';
                });
                
                // Vérifier si l'item existe et récupérer le premier résultat
                if (!empty($contact_item)) :
                    $contact_item = reset($contact_item); // Prend le premier élément de l'array filtré
                ?>
                    <i class="fas fa-envelope place-self-center"></i> <!-- Icône d'enveloppe -->
                    <span><a href="<?php echo esc_url($contact_item['url']); ?>"><?php echo esc_html($contact_item['title']); ?></a></span>
                <?php endif; ?>
            </div>

            <!-- Bouton Hamburger pour Mobile -->
            <button id="menu-toggle" class="flex gap-2 m-8 p-2 place-self-center border-solid border-2 border-stone-700	 xl:hidden">
                <div>
                    <!-- Icône Hamburger Fermé (3 lignes complètes) -->
                    <svg id="icon-menu-closed" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>

                    <!-- Icône Hamburger Ouvert (2 lignes complètes, 1 ligne plus petite) -->
                    <svg id="icon-menu-opened" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </div>    
                <span>MENU</span>
            </button>
        </div>
    </div>
</header>

<!-- Sidebar pour le menu hamburger -->
<aside id="sidebar-menu" class="fixed top-0 left-0 w-64 h-full bg-white text-black shadow-2xl transform -translate-x-full transition-transform duration-300">
    <div class="flex flex-col m-4">
        <button id="close-sidebar" class="self-end">
            <!-- Icône de fermeture de la sidebar -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <a href="<?php echo home_url(); ?>" class="w-56 h-auto bg-red-800">
            <img src="<?php echo $menu_logo['url']; ?>">
        </a>

        <ul class="flex flex-col gap-4">
            <!-- Liste des éléments du menu -->
            <?php foreach ($menu_data as $item): ?>
                <?php if (!empty($item['children'])): ?>
                    <li class="menu-burger relative p-2 flex flex-col gap-2">
                        <div class="flex gap-2 justify-between items-center">
                            <a class="hover:text-secondary" href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?>   
                            </a>
                            <span class="p-2 border-2 border-stone-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="black" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </span>
                        </div>
                        <ul class="sub-menu-burger hidden bg-white">
                            <?php foreach ($item['children'] as $child): ?>
                                <li class="sub-menu-item-burger p-2 hover:font-bold"><a class="hover:text-secondary" href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['title']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>  
                    <li class="relative lg:hover:bg-transparent p-2">
                        <a class="hover:text-secondary" href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>

<style>
/* Sous-menu initialement caché avec scaleY */
.sub-menu {
    transform: scaleY(0);
    transform-origin: top center;
    transition: transform 0.3s ease-in-out;
    position: absolute;
    background: #fff;
    top: calc(100% + 1rem);
    left: 0;
    min-width: 200px;
    z-index: 10;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);
    border-radius: 3px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    pointer-events: none;
    visibility: hidden;
    opacity: 0;
    position: absolute;
    top: 100%; /* Positionner le sous-menu directement en dessous de l'élément parent */
    left: 0;
}

/* Afficher le sous-menu au survol de l'élément parent */
.menu-item-has-children:hover .sub-menu, 
.menu-item-has-children:focus-within .sub-menu {
    transform: scaleY(1);
    pointer-events: auto;
    visibility: visible;
    opacity: 1;
}

/* Rotation de l'icône ">" au survol de l'élément parent */
.menu-item-has-children:hover > a::after {
    transform: rotate(90deg);
}

/* Style de l'icône */
.menu-item-has-children > a::after {
    content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="black" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>');
    display: inline-block;
    vertical-align: middle;
    margin-top: 0.05rem;
    transform: rotate(0);
    transition: transform 0.3s ease;
}

.menu-item-has-children {
    position: relative; /* Assurer que le sous-menu est positionné par rapport à l'élément parent */
}

/* Sous-élément de menu */
.sub-menu a {
    position: relative; /* Pour permettre l'affichage de la barre */
}

/* Barre visuelle qui apparaît à gauche sur hover */
.sub-menu a:hover::before {
    content: '';
    position: absolute;
    left: -10px; /* Ajuste la distance par rapport à l'élément */
    top: 50%;
    transform: translateY(-50%);
    width: 3px; /* Largeur de la barre */
    height: 150%; /* Hauteur de la barre, peut être ajustée */
    background-color: #FF231F; /* Couleur de la barre */
}

/* Supprimer le changement de couleur de fond au survol */
.sub-menu a:hover {
    background-color: transparent;

}

/* Barre visuelle qui apparaît à gauche sur hover */
.rotate-90 > a::after {
    transform: rotate(90deg);
    transition: transform 0.3s ease;
}

#sidebar-menu {
    overflow-y: auto;
    max-height: 100vh;
    -webkit-overflow-scrolling: touch; /* Pour un scroll fluide sur mobile */
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menu-toggle');
    var sidebarMenu = document.getElementById('sidebar-menu');
    var closeSidebar = document.getElementById('close-sidebar');
    var iconMenuClosed = document.getElementById('icon-menu-closed');
    var iconMenuOpened = document.getElementById('icon-menu-opened');

    var menuBurger = document.getElementById('menu-burger');
    var subMenuBurger = document.getElementById('sub-menu-burger');

    // Sélectionner tous les éléments de menu avec sous-menus
    const menuItemsWithChildren = document.querySelectorAll('.menu-burger');

    // Fonction pour fermer la sidebar
    function closeSidebarMenu() {
        sidebarMenu.classList.add('-translate-x-full'); // Cacher la sidebar
        iconMenuClosed.classList.remove('hidden'); // Afficher l'icône hamburger fermé
        iconMenuOpened.classList.add('hidden'); // Cacher l'icône hamburger ouvert
    }

    // Ouverture de la sidebar
    menuToggle.addEventListener('click', function() {
        // Afficher/masquer le menu burger
        sidebarMenu.classList.toggle('-translate-x-full');
        iconMenuClosed.classList.toggle('hidden');
        iconMenuOpened.classList.toggle('hidden');
    });

    // Parcourir chaque élément parent pour lui ajouter un événement de clic
    menuItemsWithChildren.forEach(menuItem => {
        const toggleIcon = menuItem.querySelector('svg'); // Icône de flèche du menu parent
        const subMenu = menuItem.querySelector('.sub-menu-burger'); // Sous-menu de cet élément

        menuItem.addEventListener('click', function(event) {
            event.preventDefault(); // Empêcher le comportement par défaut du lien

            // Basculer la classe 'hidden' pour afficher/masquer le sous-menu
            if (subMenu.classList.contains('hidden')) {
                subMenu.classList.remove('hidden');
                toggleIcon.classList.add('rotate-90'); // Ajouter une rotation à l'icône
            } else {
                subMenu.classList.add('hidden');
                toggleIcon.classList.remove('rotate-90'); // Réinitialiser l'icône
            }
        });
    });

    // Fermeture de la sidebar quand on clique sur le bouton fermer
    closeSidebar.addEventListener('click', function() {
        closeSidebarMenu();
    });

    // Fonction pour fermer la sidebar quand l'écran est redimensionné à lg (1024px ou plus)
    function closeMenuOnResize() {
        if (window.innerWidth >= 1280) { // Taille de l'écran >= 1024px
            closeSidebarMenu(); // Appel à la fonction pour fermer la sidebar
        }
    }

    // Ajouter un écouteur sur le redimensionnement de la fenêtre
    window.addEventListener('resize', closeMenuOnResize);

    // Appeler immédiatement la fonction pour s'assurer que le menu est bien fermé au chargement si l'écran est large
    closeMenuOnResize();
    });


</script>

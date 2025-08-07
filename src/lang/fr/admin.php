<?php

return [
    'content' => [
        'edit' => 'Éditer le contenu',
        'created' => 'Le contenu a été créé.',
        'updated' => 'Le contenu a été mis à jour.',
        'deleted' => 'Le contenu a été supprimé.',
        'description' => 'Description',
        'name' => 'Nom',
        'title' => 'Titre',
        'value' => 'Contenu',
        'slug' => 'Slug',
        'article' => [
            'value' => '{0}Articles|[1,1]un article|[2,*]les articles'
        ],
        'category' => [
            'value' => '{0}Catégories|[1,1]une catégorie|[2,*]les catégories',
        ],
        'page' => [
            'value' => '{0}Pages|[1,1]une page|[2,*]les pages'
        ],
        'template' => [
            'value' => '{0}Modèles|[1,1]un modèle|[2,*]les modèles'
        ],
        'type' => [
            'article' => 'Article',
            'page' => 'Page',
            'header' => 'En-tête',
            'footer' => 'Pied de page',
            'value' => 'Type'
        ],
        'status' => [
            'archived' => 'Archivé',
            'draft' => 'Brouillon',
            'published' => 'Publié',
            'value' => 'Statut',
        ],
        'published_at' => 'Date de publication'
    ],
    'editor' => [
        'category' => [
            'layout' => 'Disposition',
            'template' => 'Modèle',
        ],
        'item' => [
            'delete' => [
                'confirmed' => 'Le composant a bien été supprimé.',
            ],
        ],
        'parse' => [
            'error' => 'Impossible de parser les données de l\'éditeur visuel.',
        ],
        'sidebar' => [
            'action' => [
                'copy' => [
                    'component' => 'Copier le composant',
                    'instructions' => 'Vous pouvez coller le composant sur une autre page (CTRL + V).',
                    'page' => 'Copier le code de la page',
                    'success' => 'Le code a été copié.',
                ],
            ],
            'close' => 'Fermer',
            'component' => [
                'add' => 'Ajouter un composant',
                'all' => 'Tous les composants',
                'delete' => 'Supprimer un composant',
                'search' => 'Rechercher un composant',
                'unknown' => 'Composant inconnu',
            ],
            'empty' => 'Vous n\'avez pas encore de contenu',
            'field' => [
                'htmltext' => [
                    'alignment' => [
                        'center' => 'Aligner au centre',
                        'justify' => 'Justifier le texte',
                        'left' => 'Aligner à gauche',
                        'right' => 'Aligner à droite',
                        'unset' => 'Réinitialiser l\'alignement du texte',
                    ],
                    'bold' => 'Gras',
                    'color' => 'Couleur',
                    'formatting' => [
                        'remove' => 'Supprimer tout le formatage',
                    ],
                    'heading' => 'Titre :nr',
                    'highlight' => 'Mise en valeur',
                    'italic' => 'Italique',
                    'link' => [
                        'unlink' => 'Retirer le lien',
                        'value' => 'Lien',
                    ],
                    'list' => [
                        'lift' => 'Descendre l\'élément de la liste',
                        'sink' => 'Monter l\'élément de la liste',
                        'value' => 'Liste',
                    ],
                    'redo' => 'Refaire',
                    'strike' => 'Barré',
                    'underline' => 'Souligner',
                    'undo' => 'Annuler',
                    'video' => 'Vidéo',
                ],
            ],
            'item' => 'Éléments',
            'mode' => [
                'responsive' => 'Vue adaptative',
            ],
            'tabs' => [
                'animation' => [
                    'delay' => 'Délai',
                    'general' => 'Général',
                    'value' => 'Animations',
                    'view-transition-name' => 'Nom de transition de la vue',
                ],
                'appearance' => 'Apparence',
                'automatic-gallery' => [
                    'row' => [
                        'height' => 'Hauteur d\'une ligne',
                    ],
                    'value' => 'Galerie automatique',
                ],
                'background' => [
                    'color' => 'Couleur de fond',
                    'image' => [
                        'position' => [
                            'bottom' => 'Bas',
                            'center' => 'Centre',
                            'left' => 'Gauche',
                            'right' => 'Droite',
                            'top' => 'Haut',
                            'x' => 'Position (X)',
                            'y' => 'Position (Y)',
                        ],
                        'repeat' => [
                            'no' => 'Pas de répétition',
                            'value' => 'Répétition',
                        ],
                        'size' => [
                            'auto' => 'Originale',
                            'contain' => 'Contenir',
                            'cover' => 'Remplir',
                            'value' => 'Taille de l\'image',
                        ],
                        'opacity' => 'Opacité',
                        'value' => 'Image de fond',
                    ],
                    'value' => 'Fond',
                ],
                'border' => [
                    'color' => 'Couleur de la bordure',
                    'radius' => [
                        'bottomleft' => 'Bas Gauche',
                        'bottomright' => 'Bas Droite',
                        'topleft' => 'Haut Gauche',
                        'topright' => 'Haut Droite',
                        'value' => 'Rayon de la bordure',
                    ],
                    'line' => [
                        'blink' => 'Clignoter',
                        'line-through' => 'Line à travers',
                        'underline' => 'Souligner',
                        'overline' => 'Surligner',
                        'value' => 'Ligne de bordure',
                    ],
                    'style' => [
                        'dashed' => 'Tiré',
                        'dotted' => 'Pointillé',
                        'solid' => 'Solide',
                        'wavy' => 'Vague',
                        'value' => 'Style de bordure',
                    ],
                ],
                'carousel' => [
                    'items-per-page' => 'Éléments par pages',
                    'value' => 'Carrousel',
                ],
                'contact' => [
                    'subject' => [
                        'option' => 'Option',
                        'value' => 'Sujet',
                    ],
                    'value' => 'Formulaire de contact',
                ],
                'content' => 'Contenu',
                'ctas' => 'Appels à l\'action',
                'even-columns' => 'Colonnes',
                'form' => [
                    'value' => 'Formulaire',
                    'sections' => [
                        'value' => 'Sections',
                        'visible' => 'Visible',
                    ],
                    'fields' => [
                        'value' => 'Champs',
                        'type' => 'Type',
                        'options' => 'Options',
                        'label' => 'Label',
                        'help' => 'Aide'
                    ]
                ],
                'grid' => [
                    'gap' => 'Espacement',
                    'item' => [
                        'size' => [
                            'min' => 'Taille min. d\'un élément',
                        ],
                    ],
                    'value' => 'Grille',
                ],
                'header' => 'En-tête',
                'hero' => 'Héro',
                'image' => [
                    'alt' => 'Alt',
                    'height' => [
                        'help' => 'Laisser vide pour une hauteur automatique.',
                        'value' => 'Hauteur',
                    ],
                    'value' => 'Image',
                ],
                'images' => 'Images',
                'label' => [
                    'help' => 'Laisser vide pour conserver le nom de la page.',
                    'value' => 'Étiquette',
                ],
                'link' => [
                    'home' => 'Page d\'accueil',
                    'blog' => 'Articles',
                    'login' => 'Se connecter',
                    'profile' => 'Profil',
                    'type' => [
                        'external' => 'Lien externe',
                        'internal' => 'Lien interne',
                        'value' => 'Type de lien',
                    ],
                    'url' => 'URL',
                    'value' => 'Lien',
                ],
                'links' => 'Liens',
                'padding' => [
                    'block' => 'Espacement vertical',
                    'inline' => 'Espacement horizontal',
                ],
                'section' => 'Section',
                'theme-switcher' => 'Thème',
                'title' => [
                    'color' => 'Couleur',
                    'level' => 'Niveau',
                    'value' => 'Titre',
                ],
            ],
            'template' => [
                'choose' => 'Choisir un modèle',
                'use' => 'Utiliser un modèle',
            ],
        ],
    ],
];
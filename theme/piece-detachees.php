<?php

/**
 * Template Name: Pièces détachées
 * Template Post Type: page
 *
 * @package UnderscoreTW
 */

get_header();

?>

<?php if( $pdf_offres = get_field('pdf') ): ?>
    <a href="<?php echo esc_url($pdf_offres['url']); ?>" target="_blank">Télécharger les Offres du moment</a>
<?php endif; ?>

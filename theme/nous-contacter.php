<?php

/**
 * Template Name: Nous contacter
 * Template Post Type: page
 *
 * @package UnderscoreTW
 */

 get_header();

 ?>

<div class="custom-form-container p-8">
    <?php echo do_shortcode('[contact-form-7 id="2e51c5b" title="Formulaire de contact"]'); ?>
</div>

<!-- <style>
    .custom-form-container {
        background-color: #f3f4f6; /* bg-gray-100 */
        padding: 1.5rem; /* p-6 */
        border-radius: 0.375rem; /* rounded-md */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-lg */
    }

    .custom-form-container .wpcf7-form input,
    .custom-form-container .wpcf7-form textarea {
        border: 1px solid #d1d5db; /* border-gray-300 */
        border-radius: 0.375rem; /* rounded-md */
        padding: 0.5rem; /* p-2 */
        width: 100%; /* w-full */
    }

    .custom-form-container .wpcf7-form input[type="submit"] {
        background-color: #3b82f6; /* bg-blue-500 */
        color: white; /* text-white */
        padding: 0.5rem 1rem; /* py-2 px-4 */
        border-radius: 0.375rem; /* rounded-md */
        cursor: pointer;
    }

    .custom-form-container .wpcf7-form input[type="submit"]:hover {
        background-color: #1d4ed8; /* hover:bg-blue-700 */
    }
</style> -->

<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, CMS Theme already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */

get_header(); ?>
<div class="no-container">
    <section id="primary" class="col-xs-12">
        <div id="content" role="main">
            <?php
            $term = get_term_by( 'slug', get_query_var( 'category-portfolio' ), get_query_var( 'taxonomy' ) );

                echo apply_filters('the_content','[cms_grid source="size:15|order_by:date|post_type:portfolio|tax_query:'.$term->term_id.'" layout="masonry" col_xs="1" col_sm="2" col_md="4" col_lg="4" cms_portfolio_thumb="wide" filter="false" cms_template="cms_grid--portfolio-wide.php"]');
            ?>
        </div><!-- #content -->
    </section><!-- #primary -->
</div>
<?php get_footer(); ?>
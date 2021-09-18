<?php 
get_header();
?>
<h1>blog page</h1>
<?php 
while(have_posts()) {
    the_post(); ?>
<div class="post-item">
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="metabox">
        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
    </div>
    <div class="generic-content">
        <?php the_excerpt(); ?>
        <p><a href="<?php the_permalink(); ?>">Continue reading</a></p>
    </div>
</div>
<?php
}
// next blog page
echo paginate_links();
?>

<?php
get_footer();
?>
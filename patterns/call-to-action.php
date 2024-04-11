<?php
/**
 * Title: Call to Action
 * Slug: block-theme/call-to-action
 * Description: A call to action block with a heading, paragraph, and button.
 * Viewport Width: 1024
 * Categories: featured
 * Keywords: subscribe, newsletter, sign up
 * Block Types: core/group
 * Inserter: yes
 *
 * @package BlockTheme
 */

?>
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"}}},"backgroundColor":"foreground","textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide has-background-color has-foreground-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">Subscribe to our newsletter</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">BlockTheme is constantly improving and we share the latest features and work we're doing with our subscribers first.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Sign Up</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

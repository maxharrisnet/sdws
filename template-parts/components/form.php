<?php

/**
 * Generic form component wrapper.
 *
 * @package Starter_Coat
 */

$shortcode = isset($args['shortcode']) ? (string) $args['shortcode'] : '';
?>
<div class="c-form">
  <?php if ($shortcode) : ?>
    <?php echo do_shortcode($shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
    ?>
  <?php else : ?>
    <form>
      <label for="starter-name"><?php esc_html_e('Name', 'starter-coat'); ?></label>
      <input id="starter-name" type="text" placeholder="<?php esc_attr_e('Your name', 'starter-coat'); ?>" />
      <button class="btn btn--primary btn--md" type="submit"><?php esc_html_e('Submit', 'starter-coat'); ?></button>
    </form>
  <?php endif; ?>
</div>
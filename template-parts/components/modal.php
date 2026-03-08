<?php

/**
 * Video/Form modal component.
 *
 * @package Starter_Coat
 */

$id = isset($args['id']) ? sanitize_html_class($args['id']) : 'starter-modal';
?>
<div id="<?php echo esc_attr($id); ?>" class="modal" aria-hidden="true">
  <div class="modal__dialog" role="dialog" aria-modal="true">
    <button type="button" class="modal__close" data-modal-close><?php esc_html_e('Close', 'starter-coat'); ?></button>
    <div class="modal__content">
      <?php if (! empty($args['content'])) : ?>
        <?php echo $args['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      <?php endif; ?>
    </div>
  </div>
</div>
<time class="updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
<?php if (is_single()): ?><?php edit_post_link('edit', '<p>', '</p>'); ?><?php endif; ?>

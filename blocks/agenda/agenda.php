<?php

if ( have_rows('agenda_tabs') ) :

$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

if( $custom_padding ) {
	$paddings = '';

	if ( have_rows('custom_padding_ld')) {
		while (have_rows('custom_padding_ld')) {
			the_row();
			$padding_top = get_sub_field('padding_top');
			$padding_bottom = get_sub_field('padding_bottom');
			$padding_left = get_sub_field('padding_left');
			$padding_right = get_sub_field('padding_right');

			if( ! empty($padding_top) ) {
				$paddings .= ' --b-agenda-space-top-ld: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-agenda-space-bottom-ld: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-agenda-space-left-ld: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-agenda-space-right-ld: ' . $padding_right . ';';
			}
		}
	}
	if ( have_rows('custom_padding_mt')) {
		while (have_rows('custom_padding_mt')) {
			the_row();
			$padding_top = get_sub_field('padding_top');
			$padding_bottom = get_sub_field('padding_bottom');
			$padding_left = get_sub_field('padding_left');
			$padding_right = get_sub_field('padding_right');

			if( ! empty($padding_top) ) {
				$paddings .= ' --b-agenda-space-top-mt: ' . $padding_top . ';';
			}
			if( ! empty($padding_bottom) ) {
				$paddings .= ' --b-agenda-space-bottom-mt: ' . $padding_bottom . ';';
			}
			if( ! empty($padding_left) ) {
				$paddings .= ' --b-agenda-space-left-mt: ' . $padding_left . ';';
			}
			if( ! empty($padding_right) ) {
				$paddings .= ' --b-agenda-space-right-mt: ' . $padding_right . ';';
			}
		}
	}
}

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class = 'il_block il_agenda ';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if( get_field('stack_tabs') ) {
    $class .= ' ' . 'stack_tabs';
}
if ( ! empty( $margin ) ) {
    $class .=  ' ' . $margin['value'];
}

if ( ! empty( $padding) ) {
    $class .=  ' ' . $padding['value'];
}

 ?>
<div <?php echo $anchor; ?> class="<?php echo $class ?>" <?php if ( $custom_padding ) echo 'style="' . $paddings . '"'; ?>>
<?php get_template_part('components/background'); ?>
<div class="container">
	<?php get_template_part('components/intro'); ?>
		<div class="il_agenda_wrap">
				<?php while( have_rows('agenda_tabs') ) : the_row(); ?>
					<?php
					if( have_rows('time_slot') ):

						while( have_rows('time_slot') ) : the_row();

							$agenda_time = get_sub_field('agenda_time');
							$agenda_title = get_sub_field('agenda_title');
							$agenda_content = get_sub_field('tab_content'); ?>
							
							<div class="il_agenda_content">
								<div class="il_ac_time">
									<?php echo $agenda_time; ?>
								</div>
								<div class="il_ac_content_container">
									<?php if ( $agenda_title ) { ?>
										<div class="il_ac_title">
											<?php echo $agenda_title; ?>
										</div>
									<?php } ?>
									<?php if ( $agenda_content ) { ?>
										<div class="il_ac_content">
											<?php echo $agenda_content; ?>
										</div>
									<?php } ?>
										<?php
											if( have_rows('speakers') ): ?>
												<div class="il_ac_speakers">
												<?php while( have_rows('speakers') ) : the_row();

												$speaker_name = get_sub_field('speaker_name');
												$speaker_position = get_sub_field('speaker_position');
												?>
													<div class="il_ac_speaker">
														<div class="il_ac_speaker_name">
															<?php echo $speaker_name; ?>
														</div>
														<div class="il_ac_speaker_position">
															<?php echo $speaker_position; ?>
														</div>
													</div>
													<?php endwhile; ?>
												</div>
										<?php endif; ?>
								</div>
							</div>
						<?php
						 // End loop.
						endwhile;
					endif; ?>
				<?php endwhile; ?>
		</div>
	</div>
</div>
<?php endif; ?>

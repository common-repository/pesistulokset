<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * @package Pesistulokset
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$attributes = wp_parse_args( (array) $attributes, PESISTULOKSET_MATCHES_API_DEFAULTS );
$results    = pesistulokset_get_matches( $attributes );
$today      = gmdate( 'U' );
?>
<div id="<?php echo esc_attr( $attributes['blockId'] ); ?>" <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $results ) : ?>
		<div class="pt-wrapper">
			<div class="pt-matches">
				<?php foreach ( $results as $match ) : ?>
					<?php
						$match_date = gmdate( 'U', strtotime( $match['date'] ) );

						if ( true === $attributes['showHome'] ) {
							if ( $attributes['team'] && $attributes['team'] !== $match['home']['name'] ) {
								continue;
							}
						}

						if ( 'future' === $attributes['showGames'] && $match_date < $today ) {
							continue;
						}

						if ( 'past' === $attributes['showGames'] && $match_date > $today ) {
							continue;
						}
					?>

					<div id="match-<?php echo esc_attr( $match['id'] ); ?>" class="pt-match">
						<div class="match-date">
							<?php echo esc_html( get_date_from_gmt( gmdate( 'd.m.Y H:i:s', strtotime( $match['date'] ) ), get_option( 'date_format' ) . ' \k\l\o. ' . get_option( 'time_format' ) ) ); ?>

							<div class="stadium">
								<?php echo esc_html( $match['stadium']['name'] ); ?>
							</div>
						</div>

						<div class="teams">
							<div class="home">
								<div class="team-logo"><img loading="lazy" src="<?php echo esc_url( $match['home']['icon'] ); ?>" alt="<?php echo esc_html( $match['home']['name'] ); ?>"></div>
								<div class="team-name"><?php echo esc_html( $match['home']['name'] ); ?></div>
							</div>
							<div class="match-results">
								<div class="match-score">
									<?php if ( ! empty( $match['result'] ) ) : ?>
										<?php echo esc_html( $match['result']['periods_home'] ) . ' - ' . esc_html( $match['result']['periods_away'] ); ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="away">
								<div class="team-logo"><img loading="lazy" src="<?php echo esc_url( $match['away']['icon'] ); ?>" alt="<?php echo esc_html( $match['away']['name'] ); ?>"></div>
								<div class="team-name"><?php echo esc_html( $match['away']['name'] ); ?></div>
							</div>
						</div>

						<?php if ( ! empty( $match['result'] ) ) : ?>
						<div class="match-periods">
							<?php echo esc_html( $match['result']['result_string_periods'] ); ?>
						</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</div>

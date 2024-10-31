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

$styles  = '--pesistulokset-highlight-color:' . $attributes['customHighlightColor'] . ';';
$styles .= '--pesistulokset-highlight-bg-color:' . $attributes['customHighlightBgColor'] . ';';
$styles .= '--pesistulokset-header-color:' . $attributes['customHeaderColor'] . ';';
$styles .= '--pesistulokset-header-bg-color:' . $attributes['customHeaderBgColor'] . ';';
?>
<div id="<?php echo esc_attr( $attributes['blockId'] ); ?>" <?php echo get_block_wrapper_attributes( array( 'style' => $styles ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php
	$attributes = wp_parse_args( (array) $attributes, PESISTULOKSET_API_DEFAULTS );
	$columns    = $attributes['columns'];
	$results    = pesistulokset_get_results( $attributes );
	?>

	<?php if ( $results ) : ?>
		<div class="pt-wrapper">
		<?php if ( $attributes['showHeader'] ) : ?>
			<div class="pt-results-header">
				<span class="header-title">
					<?php
					switch ( $attributes['series'] ) {
						case 'Miehet':
							$series = __( 'Miesten', 'pesistulokset' );
							break;
						case 'Naiset':
							$series = __( 'Naisten', 'pesistulokset' );
							break;
						case 'Pojat':
							$series = __( 'Poikien', 'pesistulokset' );
							break;
						case 'Tytöt':
							$series = __( 'Tyttöjen', 'pesistulokset' );
							break;
						default:
							$series = '';
							break;
					}
					?>
					<?php echo esc_html( $series . ' ' . $attributes['level'] . ' ' . $attributes['season'] ); ?>
				</span>
				<div class="series-logo">
					<img loading="lazy" src="<?php echo esc_url( PESISTULOKSET_BASE_URL . 'public/images/' . strtolower( $attributes['level'] ) . '-logo.svg' ); ?>" alt="<?php echo esc_attr( $attributes['level'] ); ?>">
				</div>
			</div>
		<?php endif; ?>
			<div class="pt-table-wrapper">
				<table class="pt-results-table">
					<thead>
						<tr>
						<th class="pt-name"><span class="position">#</span><span><?php esc_html_e( 'Joukkue', 'pesistulokset' ); ?></span></th>
							<?php if ( in_array( 'O', $columns, true ) ) : ?>
								<th class="pt-games"><?php esc_html_e( 'O', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( 'V', $columns, true ) ) : ?>
								<th class="pt-wins pt-hidden-mobile"><?php esc_html_e( 'V', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( 'T', $columns, true ) ) : ?>
								<th class="pt-draws pt-hidden-mobile"><?php esc_html_e( 'T', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( 'H', $columns, true ) ) : ?>
								<th class="pt-losses pt-hidden-mobile"><?php esc_html_e( 'H', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( '3P', $columns, true ) ) : ?>
								<th class="pt-3p pt-hidden-mobile pt-hidden-tablet"><?php esc_html_e( '3P', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( '2P', $columns, true ) ) : ?>
								<th class="pt-2p pt-hidden-mobile pt-hidden-tablet"><?php esc_html_e( '2P', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( '1P', $columns, true ) ) : ?>
								<th class="pt-1p pt-hidden-mobile pt-hidden-tablet"><?php esc_html_e( '1P', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( '0', $columns, true ) ) : ?>
								<th class="pt-0p pt-hidden-mobile pt-hidden-tablet"><?php esc_html_e( '0', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( 'J', $columns, true ) ) : ?>
								<th class="pt-runs"><?php esc_html_e( 'Juoksut', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( 'P', $columns, true ) ) : ?>
								<th class="pt-points"><?php esc_html_e( 'P', 'pesistulokset' ); ?></th>
							<?php endif; ?>
							<?php if ( in_array( 'PPG', $columns, true ) ) : ?>
								<th class="pt-ppg pt-hidden-mobile pt-hidden-tablet"><?php esc_html_e( 'PPG', 'pesistulokset' ); ?></th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php if ( $results ) : ?>
							<?php foreach ( $results as $result ) : ?>

								<?php
									$classes = array(
										'team-' . esc_attr( sanitize_title( $result['team']['name'] ) ),
									);

									if ( $result['team']['shorthand'] === $attributes['highlight'] ) {
										$classes[] = 'team-highlighted';
									}
								?>

								<tr id="<?php echo esc_attr( $result['team']['id'] ); ?>" class="<?php echo implode( ' ', $classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
									<td class="pt-name">
										<span class="position"><?php echo esc_html( $result['num'] ); ?>.</span>
										<?php /* translators: %1$s: Team name */ ?>
										<img loading="lazy" src="<?php echo esc_url( $result['team']['icon'] ); ?>" alt="<?php echo wp_sprintf( esc_html__( 'Joukkueen %1$s logo', 'pesistulokset' ), esc_html( $result['team']['name'] ) ); ?>">
										<span class="pt-team-name">
											<?php echo esc_html( $result['team']['name'] ); ?>
										</span>
										<span class="pt-team-name-short">
											<?php echo esc_html( $result['team']['shorthand'] ); ?>
										</span>
									</td>
									<?php if ( in_array( 'O', $columns, true ) ) : ?>
										<td class="pt-games"><?php echo esc_html( $result['stats']['matches'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( 'V', $columns, true ) ) : ?>
										<td class="pt-wins pt-hidden-mobile"><?php echo esc_html( $result['stats']['wins'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( 'T', $columns, true ) ) : ?>
										<td class="pt-draws pt-hidden-mobile"><?php echo esc_html( $result['stats']['draws'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( 'H', $columns, true ) ) : ?>
										<td class="pt-losses pt-hidden-mobile"><?php echo esc_html( $result['stats']['losses'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( '3P', $columns, true ) ) : ?>
										<td class="pt-3p pt-hidden-mobile pt-hidden-tablet"><?php echo esc_html( $result['stats']['3p'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( '2P', $columns, true ) ) : ?>
										<td class="pt-2p pt-hidden-mobile pt-hidden-tablet"><?php echo esc_html( $result['stats']['2p'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( '1P', $columns, true ) ) : ?>
										<td class="pt-1p pt-hidden-mobile pt-hidden-tablet"><?php echo esc_html( $result['stats']['1p'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( '0', $columns, true ) ) : ?>
										<td class="pt-0p pt-hidden-mobile pt-hidden-tablet"><?php echo esc_html( $result['stats']['0p'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( 'J', $columns, true ) ) : ?>
										<td class="pt-runs"><?php echo esc_html( $result['stats']['runsFor'] ); ?>-<?php echo esc_html( $result['stats']['runsAgainst'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( 'P', $columns, true ) ) : ?>
										<td class="pt-points"><?php echo esc_html( $result['stats']['points'] ); ?></td>
									<?php endif; ?>
									<?php if ( in_array( 'PPG', $columns, true ) ) : ?>
										<td class="pt-ppg pt-hidden-mobile pt-hidden-tablet"><span title="<?php echo esc_html( $result['stats']['ppg'] ); ?>"><?php echo esc_html( number_format( (float) $result['stats']['ppg'], 2 ) ); ?></span></td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php else : ?>
		<p class="pt-no-results"><?php esc_html_e( 'Sarjataulukkoa ei löytynyt', 'pesistulokset' ); ?></p>
	<?php endif; ?>
</div>

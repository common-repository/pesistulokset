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

$attributes = wp_parse_args( (array) $attributes, PESISTULOKSET_STATS_API_DEFAULTS );
$results    = pesistulokset_get_stats( $attributes );
$cols       = $results['cols'];
?>

<div id="<?php echo esc_attr( $attributes['blockId'] ); ?>" <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $results ) : ?>
		<div class="pt-wrapper">

			<div class="pt-table-wrapper">
				<table class="pt-stats-table">
					<thead>
						<tr>
							<th width="50px"></th>
							<th><?php esc_html_e( 'Nimi', 'pesistulokset' ); ?></th>
							<th><?php esc_html_e( 'Joukkue', 'pesistulokset' ); ?></th>
							<?php foreach ( $cols as $col ) : ?>
								<th title="<?php echo esc_attr( $col['longName'] ); ?>"><?php echo esc_html( $col['shortName'] ); ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $results['data'] as $result ) : ?>
							<tr id="<?php echo esc_attr( 'player-' . $result['player_id'] ); ?>">
								<td width="50px">
									<div class="player-image">
										<img loading="lazy" src="<?php echo ( ! is_null( $result['player']['image']['medium'] ) ? esc_url( $result['player']['image']['medium'] ) : esc_url( PESISTULOKSET_BASE_URL . 'public/images/player-placeholder.png' ) ); ?>" alt="<?php echo esc_attr( $result['player']['name'] ); ?>">
									</div>
								</td>
								<td class="player-name">
									<span class="name"><?php echo esc_html( $result['player']['name'] ); ?></span>
								</td>
								<td class="player-name">
									<?php if ( $result['teams'] ) : ?>
										<?php foreach ( $result['teams'] as $team ) : ?>
											<div class="team">
												<div class="team-logo">
													<img src="<?php echo esc_url( $team['icon'] ); ?>" alt="">
												</div>
												<div class="team-name"><span><?php echo esc_html( $team['name'] ); ?></span></div>
											</div>
										<?php endforeach; ?>
									<?php endif; ?>
								</td>
								<?php foreach ( $cols as $col ) : ?>
									<td><?php echo esc_html( $result['stats'][ $col['colName'] ] ); ?></td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php else : ?>
		<p class="pt-no-results"><?php esc_html_e( 'Tilastoja ei löytynyt', 'pesistulokset' ); ?></p>
	<?php endif; ?>
</div>

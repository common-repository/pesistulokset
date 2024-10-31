<?php
/**
 * Register shortcodes.
 *
 * @link       https://miikasalo.com
 * @since      1.0.0
 *
 * @package    Pesistulokset
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register short to display results.
 */
function pesistulokset_shortcode( $atts ) {

	$args                = PESISTULOKSET_API_DEFAULTS;
	$args['highlight']   = ''; // Allow highlighting a team. Uses team shorthand as value.
	$args['columns']     = 'o,v,t,h,3p,2p,1p,0,j,p'; // Which columns are shown.
	$args['show_header'] = 'true'; // Show / hide header.

    $atts    = shortcode_atts( $args, $atts );
	$columns = ( ! empty( $atts['columns'] ) ? array_map( 'strtolower', array_map( 'trim', explode( ',', $atts['columns'] ) ) ) : explode( ',', $args['columns'] ) );
    $results = pesistulokset_get_results( $atts );

	if ( ! $results ) {
		return esc_html__( 'Sarjataulukkoa ei löytynyt.', 'pesistulokset' );
	}
	?>

	<?php ob_start(); ?>
	<div class="pt-wrapper">
		<?php if ( 'true' === $atts['show_header'] ) : ?>
		<div class="pt-results-header">
			<span class="header-title">
				<?php $series = ( 'Miehet' === $atts['series'] ? __( 'Miesten', 'pesistulokset' ) : __( 'Naisten', 'pesistulokset' ) ); ?>
				<?php echo esc_html( $series . ' ' . $atts['level'] . ( 'Runkosarja' !== $atts['group'] ? ' (' . $atts['group'] . ')' : '' ) ); ?>
			</span>
			<div class="series-logo">
				<img src="<?php echo esc_url( PESISTULOKSET_BASE_URL . 'public/images/' . strtolower( $atts['level'] ) . '-logo.svg' ); ?>" alt="<?php echo esc_attr( $atts['level'] ); ?>">
			</div>
		</div>
		<?php endif; ?>
		<div class="pt-table-wrapper">
			<table class="pt-results-table pt-results-shortcode">
				<thead>
					<tr>
						<th class="pt-name"><span class="position">#</span><span><?php esc_html_e( 'Joukkue', 'pesistulokset' ); ?></span></th>
						<?php if ( in_array( 'o', $columns, true ) ) : ?>
							<th class="pt-games"><?php esc_html_e( 'O', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( 'v', $columns, true ) ) : ?>
							<th class="pt-wins pt-hidden-mobile"><?php esc_html_e( 'V', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( 't', $columns, true ) ) : ?>
							<th class="pt-draws pt-hidden-mobile"><?php esc_html_e( 'T', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( 'h', $columns, true ) ) : ?>
							<th class="pt-losses pt-hidden-mobile"><?php esc_html_e( 'H', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( '3p', $columns, true ) ) : ?>
							<th class="pt-3p pt-hidden-mobile pt-hidden-tablet"><?php esc_html_e( '3P', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( '2p', $columns, true ) ) : ?>
							<th class="pt-2p pt-hidden-mobile pt-hidden-tablet"><?php esc_html_e( '2P', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( '1p', $columns, true ) ) : ?>
							<th class="pt-1p pt-hidden-mobile pt-hidden-tablet"><?php esc_html_e( '1P', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( '0', $columns, true ) ) : ?>
							<th class="pt-0p pt-hidden-mobile pt-hidden-tablet"><?php esc_html_e( '0', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( 'j', $columns, true ) ) : ?>
							<th class="pt-runs"><?php esc_html_e( 'Juoksut', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( 'p', $columns, true ) ) : ?>
							<th class="pt-points"><?php esc_html_e( 'P', 'pesistulokset' ); ?></th>
						<?php endif; ?>
						<?php if ( in_array( 'ppg', $columns, true ) ) : ?>
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

							if ( $result['team']['shorthand'] === $atts['highlight'] ) {
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
							<?php if ( in_array( 'o', $columns, true ) ) : ?>
								<td class="pt-games"><?php echo esc_html( $result['stats']['matches'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( 'v', $columns, true ) ) : ?>
								<td class="pt-wins pt-hidden-mobile"><?php echo esc_html( $result['stats']['wins'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( 't', $columns, true ) ) : ?>
								<td class="pt-draws pt-hidden-mobile"><?php echo esc_html( $result['stats']['draws'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( 'h', $columns, true ) ) : ?>
								<td class="pt-losses pt-hidden-mobile"><?php echo esc_html( $result['stats']['losses'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( '3p', $columns, true ) ) : ?>
								<td class="pt-3p pt-hidden-mobile pt-hidden-tablet"><?php echo esc_html( $result['stats']['3p'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( '2p', $columns, true ) ) : ?>
								<td class="pt-2p pt-hidden-mobile pt-hidden-tablet"><?php echo esc_html( $result['stats']['2p'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( '1p', $columns, true ) ) : ?>
								<td class="pt-1p pt-hidden-mobile pt-hidden-tablet"><?php echo esc_html( $result['stats']['1p'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( '0', $columns, true ) ) : ?>
								<td class="pt-0p pt-hidden-mobile pt-hidden-tablet"><?php echo esc_html( $result['stats']['0p'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( 'j', $columns, true ) ) : ?>
								<td class="pt-runs"><?php echo esc_html( $result['stats']['runsFor'] ); ?>-<?php echo esc_html( $result['stats']['runsAgainst'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( 'p', $columns, true ) ) : ?>
								<td class="pt-points"><?php echo esc_html( $result['stats']['points'] ); ?></td>
							<?php endif; ?>
							<?php if ( in_array( 'ppg', $columns, true ) ) : ?>
								<td class="pt-ppg pt-hidden-mobile pt-hidden-tablet"><span title="<?php echo esc_html( $result['stats']['ppg'] ); ?>"><?php echo esc_html( number_format( (float) $result['stats']['ppg'], 2 ) ); ?></span></td>
							<?php endif; ?>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<?php
	$output = ob_get_contents();

	ob_end_clean();

	return $output;
}
add_shortcode( 'pesistulokset', 'pesistulokset_shortcode' );

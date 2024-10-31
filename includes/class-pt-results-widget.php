<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Social Menu Widget
 */
class Pesistulokset_Results_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'pt-results-widget',
			__( 'Pesistulokset', 'pesistulokset' ),
			array(
				'description' => __( 'Näyttää pesistulokset', 'pesistulokset' ),
			)
		);

	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		// before and after widget arguments are defined by themes
		echo $args['before_widget']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$results = pesistulokset_get_results( $instance );

		if ( $results ) :
		?>
		<table class="pt-results-table">
			<thead>
				<tr>
					<th class="pt-name"><span class="position">#</span><span><?php esc_html_e( 'Joukkue', 'pesistulokset' ); ?></span></th>
					<th class="pt-games"><?php esc_html_e( 'O', 'pesistulokset' ); ?></th>
					<th class="pt-runs"><?php esc_html_e( 'Lj-Pj', 'pesistulokset' ); ?></th>
					<th class="pt-points"><?php esc_html_e( 'P', 'pesistulokset' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( $results ) : ?>
					<?php foreach ( $results as $result ) : ?>
					<tr <?php echo ( $result['team']['shorthand'] === $instance['highlight'] ? 'class="team-highlighted"' : '' ); ?>>
						<?php /* translators: %1$s: Team name */ ?>
						<td class="pt-name"><span class="position"><?php echo esc_html( $result['num'] ); ?>.</span><img loading="lazy" src="<?php echo esc_url( $result['team']['icon'] ); ?>" alt="<?php echo wp_sprintf( esc_html__( 'Joukkueen %1$s logo', 'pesistulokset' ), esc_html( $result['team']['name'] ) ); ?>"><?php echo esc_html( $result['team']['shorthand'] ); ?></td>
						<td class="pt-games"><?php echo esc_html( $result['stats']['matches'] ); ?></td>
						<td class="pt-runs"><?php echo esc_html( $result['stats']['runsFor'] ); ?>-<?php echo esc_html( $result['stats']['runsAgainst'] ); ?></td>
						<td class="pt-points"><?php echo esc_html( $result['stats']['points'] ); ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		<?php else : ?>
			<p><?php esc_html__( 'Sarjataulukkoa ei löytynyt.', 'pesistulokset' ); ?></p>
		<?php endif; ?>

		<?php
		echo $args['after_widget']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	// Widget Backend
	public function form( $instance ) {
		$instance  = wp_parse_args( (array) $instance, PESISTULOKSET_API_DEFAULTS );
		$season    = ! empty( $instance['season'] ) ? format_to_edit( $instance['season'] ) : '';
		$highlight = ! empty( $instance['highlight'] ) ? format_to_edit( $instance['highlight'] ) : '';
		$level     = ! empty( $instance['level'] ) ? $instance['level'] : '';
		$series    = ! empty( $instance['series'] ) ? $instance['series'] : '';
		$title     = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Otsikko:', 'pesistulokset' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'season' ) ); ?>"><?php echo esc_html( 'Kausi:' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'season' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'season' ) ); ?>" type="text" value="<?php echo esc_attr( $season ); ?>" />
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'level' ) ); ?>"><?php echo esc_html( 'Sarja:' ); ?></label>
		<select id="<?php echo esc_attr( $this->get_field_id( 'level' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'level' ) ); ?>">
			<option value=""><?php esc_html_e( 'Valitse sarja', 'pesistulokset' ); ?></option>
			<option value="Superpesis" <?php selected( $instance['level'], 'Superpesis' ); ?>><?php esc_html_e( 'Superpesis', 'pesistulokset' ); ?></option>
			<option value="Ykköspesis" <?php selected( $instance['level'], 'Ykköspesis' ); ?>><?php esc_html_e( 'Ykköspesis', 'pesistulokset' ); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'series' ) ); ?>"><?php echo esc_html( 'Taso:' ); ?></label>
		<select id="<?php echo esc_attr( $this->get_field_id( 'series' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'series' ) ); ?>">
			<option value=""><?php esc_html_e( 'Valitse taso', 'pesistulokset' ); ?></option>
			<option value="Miehet" <?php selected( $instance['series'], 'Miehet' ); ?>><?php esc_html_e( 'Miehet', 'pesistulokset' ); ?></option>
			<option value="Naiset" <?php selected( $instance['series'], 'Naiset' ); ?>><?php esc_html_e( 'Naiset', 'pesistulokset' ); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'highlight' ) ); ?>"><?php echo esc_html__( 'Korostettu joukkue:', 'pesistulokset' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'highlight' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'highlight' ) ); ?>" type="text" value="<?php echo esc_attr( $highlight ); ?>" />
		<small><?php esc_html_e( 'Käytä joukkueenlyhennystä (esim. SoJy, ViVe, KPL jne.)', 'pesistulokset' ); ?></small>
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance              = array();
		$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['season']    = ( ! empty( $new_instance['season'] ) ) ? sanitize_text_field( $new_instance['season'] ) : '';
		$instance['level']     = ( ! empty( $new_instance['level'] ) ) ? sanitize_text_field( $new_instance['level'] ) : '';
		$instance['series']    = ( ! empty( $new_instance['series'] ) ) ? sanitize_text_field( $new_instance['series'] ) : '';
		$instance['highlight'] = ( ! empty( $new_instance['highlight'] ) ) ? sanitize_text_field( $new_instance['highlight'] ) : '';

		return $instance;
	}
} // Class Pesistulokset_Results_Widget ends here

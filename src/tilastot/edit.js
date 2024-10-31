/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	InspectorControls,
} from '@wordpress/block-editor';

import {
	Disabled,
	TextControl,
	PanelBody,
	SelectControl
} from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import metadata from './block.json';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
const Edit = ( {
	attributes,
	setAttributes,
	style,
	clientId
} ) => {

	const {
		blockId,
		season,
		level,
		series,
		group,
		phase,
		region,
		team,
		type,
		stat
	} = attributes;

	const blockProps = useBlockProps( {
		className: 'pesistulokset-stats',
		style: {
			...style,
		}
	} );

	const onChangeSeason = ( newSeason ) => {
		setAttributes( { season: newSeason } );
	};

	const onChangeTeam = ( newTeam ) => {
		setAttributes( { team: newTeam } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Asetukset', 'pesistulokset' ) }
					initialOpen={ true }
				>
					<fieldset>
						<TextControl
							label={ __( 'Kausi', 'pesistulokset' ) }
							value={ season }
							onChange={ onChangeSeason }
							help={ __(
								'Vuosiluku esim. 2023. season-parametri',
								'pesistulokset'
							) }
						/>
					</fieldset>

					<fieldset>
					<TextControl
						label={__( 'Sarja', 'pesistulokset' )}
						value={ level }
						onChange={ ( val ) => setAttributes( { level: val } ) }
						help={ __(
							'Esim. Superpesis, Ykköspesis tai Suomensarja. level-parametri',
							'pesistulokset'
						) }
					/>
					</fieldset>

					<fieldset>
					<TextControl
						label={__( 'Taso', 'pesistulokset' )}
						value={ series }
						onChange={ ( val ) => setAttributes( { series: val } ) }
						help={ __(
							'Esim. Miehet tai Naiset. series-parametri',
							'pesistulokset'
						) }
					/>
					</fieldset>

					<fieldset>
					<TextControl
						label="Sarjajärjestelmä"
						value={ group }
						onChange={ ( val ) => setAttributes( { group: val } ) }
						help={ __(
							'Esim. Runkosarja. group-parametri',
							'pesistulokset'
						) }
					/>
					</fieldset>

					<fieldset>
					<TextControl
						label="Vaihe"
						value={ phase }
						onChange={ ( val ) => setAttributes( { phase: val } ) }
						help={ __(
							'Esim. Harjoitusottelut. phase-parametri',
							'pesistulokset'
						) }
					/>
					</fieldset>

					<fieldset>
					<TextControl
						label="Alue"
						value={ region }
						onChange={ ( val ) => setAttributes( { region: val } ) }
						help={ __(
							'region-parametri',
							'pesistulokset'
						) }
					/>
					</fieldset>

					<fieldset>
					<SelectControl
						label="Tyyppi"
						value={ type }
						options={ [
							{ label: 'Pelaajat', value: 'pelaajat' },
							{ label: 'Joukkueet', value: 'joukkueet' }
						] }
						onChange={ ( val ) => setAttributes( { type: val } ) }
					/>
					</fieldset>

					<fieldset>
					<SelectControl
						label="Tilasto"
						value={ stat }
						options={ [
							{ label: 'Lyödyt (pelaajat)', value: 'lyodyt' },
							{ label: 'Tuodut (pelaajat)', value: 'tuodut' },
							{ label: 'Etenemiset (pelaajat)', value: 'etenemiset' },
							{ label: 'Kärkilyönnit (pelaajat)', value: 'karkilyonnit' },
							{ label: 'Saatot (pelaajat)', value: 'saatot' },
							{ label: 'Sisäpelinumerot (pelaajat)', value: 'sisapelinumerot' },
							{ label: 'Suorat voitot (joukkueet)', value: 'suorat-voitot' },
							{ label: 'Tuodut per ottelu (joukkueet)', value: 'tuodut-per-ottelu' },
							{ label: 'Kolmostilanteet per ottelu (joukkueet)', value: 'kolmostilanteet-per-ottelu' },
							{ label: 'Kärkilyönnit per ottelu (joukkueet)', value: 'karkilyonnit-per-ottelu' },
							{ label: 'Katsojakeskiarvo (joukkueet)', value: 'katsojakeskiarvo' },
							{ label: 'Team scorings (joukkueet)', value: 'team-scorings' }
						] }
						onChange={ ( val ) => setAttributes( { stat: val } ) }
					/>
					</fieldset>

					<fieldset>
						<TextControl
							label={ __( 'Joukkue', 'pesistulokset' ) }
							value={ team }
							onChange={ onChangeTeam }
							help={ __(
								'Näyttää ainoastaan valitun joukkueen tilastot',
								'pesistulokset'
							) }
						/>
					</fieldset>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<Disabled>
					<ServerSideRender
						block={ metadata.name }
						skipBlockSupportAttributes
						attributes={ attributes }
					/>
				</Disabled>
			</div>
		</>
	);
};

export default Edit;

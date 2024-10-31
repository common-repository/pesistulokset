import { useState } from 'react';

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
	withColors,
	__experimentalColorGradientSettingsDropdown as ColorGradientSettingsDropdown,
	__experimentalUseMultipleOriginColorsAndGradients as useMultipleOriginColorsAndGradients
} from '@wordpress/block-editor';

import {
	Disabled,
	TextControl,
	PanelBody,
	CheckboxControl,
	ToggleControl

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
	clientId,
	headerColor,
	headerBgColor,
	setHeaderColor,
	setHeaderBgColor,
	highlightColor,
	highlightBgColor,
	setHighlightColor,
	setHighlightBgColor
} ) => {

	const {
		blockId,
		season,
		level,
		series,
		group,
		phase,
		region,
		columns,
		highlight,
		showHeader,
		customHeaderColor,
		customHeaderBgColor,
		customHighlightColor,
		customHighlightBgColor
	} = attributes;

	const blockProps = useBlockProps( {
		className: 'pesistulokset-block',
		style: {
			...style,
			'--pesistulokset-highlight-color': highlightColor.slug
					? `var( --wp--preset--color--${ highlightColor.slug } )`
					: customHighlightColor,
			'--pesistulokset-highlight-bg-color': highlightBgColor.slug
					? `var( --wp--preset--color--${ highlightBgColor.slug } )`
					: customHighlightBgColor,
			'--pesistulokset-header-color': headerColor.slug
					? `var( --wp--preset--color--${ headerColor.slug } )`
					: customHeaderColor,
			'--pesistulokset-header-bg-color': headerBgColor.slug
					? `var( --wp--preset--color--${ headerBgColor.slug } )`
					: customHeaderBgColor,
		}
	} );

	const colorGradientSettings = useMultipleOriginColorsAndGradients();

	const onChangeSeason = ( newSeason ) => {
		setAttributes( { season: newSeason } );
	};

	const onChangeHighlight = ( newHighlight ) => {
		setAttributes( { highlight: newHighlight } );
	};

	// Update selected checkboxes
	const onCheckboxChange = (newValue) => {
		setAttributes({ columns: newValue });
	};

	return (
		<>
			<InspectorControls group="color">
				<ColorGradientSettingsDropdown
					settings={ [ {
						label: __( 'Korostuksen tekstin väri', 'pesistulokset' ),
						colorValue: highlightColor.color || customHighlightColor,
						onColorChange: ( value ) => {
							setHighlightColor( value );
							setAttributes( {
								customHighlightColor: value
							} );
						}
					} ] }
					panelId={ clientId }
					hasColorsOrGradients={ false }
					disableCustomColors={ false }
					__experimentalIsRenderedInSidebar
					{ ...colorGradientSettings }
				/>
				<ColorGradientSettingsDropdown
					settings={ [ {
						label: __( 'Korostuksen taustaväri', 'pesistulokset' ),
						colorValue: highlightBgColor.color || customHighlightBgColor,
						onColorChange: ( value ) => {
							setHighlightBgColor( value );
							setAttributes( {
								customHighlightBgColor: value
							} );
						}
					} ] }
					panelId={ clientId }
					hasColorsOrGradients={ false }
					disableCustomColors={ false }
					__experimentalIsRenderedInSidebar
					{ ...colorGradientSettings }
				/>
				<ColorGradientSettingsDropdown
					settings={ [ {
						label: __( 'Otsakkeen tekstin väri', 'pesistulokset' ),
						colorValue: headerColor.color || customHeaderColor,
						onColorChange: ( value ) => {
							setHeaderColor( value );
							setAttributes( {
								customHeaderColor: value
							} );
						}
					} ] }
					panelId={ clientId }
					hasColorsOrGradients={ false }
					disableCustomColors={ false }
					__experimentalIsRenderedInSidebar
					{ ...colorGradientSettings }
				/>
				<ColorGradientSettingsDropdown
					settings={ [ {
						label: __( 'Otsakkeen taustaväri', 'pesistulokset' ),
						colorValue: headerBgColor.color || customHeaderBgColor,
						onColorChange: ( value ) => {
							setHeaderBgColor( value );
							setAttributes( {
								customHeaderBgColor: value
							} );
						}
					} ] }
					panelId={ clientId }
					hasColorsOrGradients={ false }
					disableCustomColors={ false }
					__experimentalIsRenderedInSidebar
					{ ...colorGradientSettings }
				/>
			</InspectorControls>

			<InspectorControls>
				<PanelBody
					title={ __( 'Asetukset', 'pesistulokset' ) }
					initialOpen={ true }
				>
					<fieldset>
						<ToggleControl
							label={__( 'Näytä otsake', 'pesistulokset' )}
							help={
								showHeader
									? __( 'Näytä sarjataulukon otsake.', 'pesistulokset' )
									: __( 'Piilota sarjataulukon otsake.', 'pesistulokset' )
							}
							checked={ showHeader }
							onChange={ (newValue) => {
								setAttributes( { showHeader: newValue } )
							} }
						/>
					</fieldset>
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
						<TextControl
							label={ __( 'Korosta joukkue', 'pesistulokset' ) }
							value={ highlight }
							onChange={ onChangeHighlight }
							help={ __(
								'Käytä joukkueen lyhennystä (esim. SoJy, ViVe, KPL jne.)',
								'pesistulokset'
							) }
						/>
					</fieldset>
				</PanelBody>
				<PanelBody
					title={ __( 'Sarakkeet', 'pesistulokset' ) }
					initialOpen={ false }
				>
					<CheckboxControl
						label={__( 'Ottelut', 'pesistulokset' )}
						checked={columns.includes('O')}
						onChange={
							(isChecked) => onCheckboxChange(isChecked ? [...columns, 'O'] : columns.filter(value => value !== 'O'))
						}
					/>
					<CheckboxControl
						label={__( 'Voitot', 'pesistulokset' )}
						checked={columns.includes('V')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, 'V'] : columns.filter(value => value !== 'V'))}
					/>
					<CheckboxControl
						label={__( 'Tasapelit', 'pesistulokset' )}
						checked={columns.includes('T')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, 'T'] : columns.filter(value => value !== 'T'))}
					/>
					<CheckboxControl
						label={__( 'Häviöt', 'pesistulokset' )}
						checked={columns.includes('H')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, 'H'] : columns.filter(value => value !== 'H'))}
					/>
					<CheckboxControl
						label={__( '3P', 'pesistulokset' )}
						checked={columns.includes('3P')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, '3P'] : columns.filter(value => value !== '3P'))}
					/>
					<CheckboxControl
						label={__( '2P', 'pesistulokset' )}
						checked={columns.includes('2P')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, '2P'] : columns.filter(value => value !== '2P'))}
					/>
					<CheckboxControl
						label={__( '1P', 'pesistulokset' )}
						checked={columns.includes('1P')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, '1P'] : columns.filter(value => value !== '1P'))}
					/>
					<CheckboxControl
						label={__( '0P', 'pesistulokset' )}
						checked={columns.includes('0')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, '0'] : columns.filter(value => value !== '0'))}
					/>
					<CheckboxControl
						label={__( 'Juoksut', 'pesistulokset' )}
						checked={columns.includes('J')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, 'J'] : columns.filter(value => value !== 'J'))}
					/>
					<CheckboxControl
						label={__( 'Pisteet', 'pesistulokset' )}
						checked={columns.includes('P')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, 'P'] : columns.filter(value => value !== 'P'))}
					/>
					<CheckboxControl
						label={__( 'PPG', 'pesistulokset' )}
						checked={columns.includes('PPG')}
						onChange={(isChecked) => onCheckboxChange(isChecked ? [...columns, 'PPG'] : columns.filter(value => value !== 'PPG'))}
					/>
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

export default withColors( {
	highlightColor: 'highlight-color',
	highlightBgColor: 'highlight-bg-color',
	headerColor: 'header-color',
	headerBgColor: 'header-bg-color',
} )( Edit );

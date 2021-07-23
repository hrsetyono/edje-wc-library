// Add Vertical Alignment to woocommerce/featured-category block

import './featured-category.sass';

import { assign } from 'lodash';
import { addFilter } from '@wordpress/hooks';
import { select } from '@wordpress/data';
import { Fragment } from '@wordpress/element';
import {
  BlockControls,
  BlockVerticalAlignmentToolbar,
  getColorObjectByColorValue,
  InspectorControls,
  PanelColorSettings } from '@wordpress/block-editor';


addFilter( 'blocks.registerBlockType', 'wc-featured-category/attributes', addAttribute );
addFilter( 'editor.BlockEdit', 'wc-featured-category/edit', addControl );


/**
 * Add the Vertical Align attribute
 */
function addAttribute( settings, name ) {
  // abort if not our targetted block
  let targetBlocks = [ 'woocommerce/featured-category', 'woocommerce/featured-product' ];
  if ( !targetBlocks.includes( name ) ) {
    return settings;
  }
  
  settings.attributes = assign( settings.attributes, {
    verticalAlignment: { type: 'string', default: 'center' },
    textColor: { type: 'string', default: 'white' },
  } );

  return settings;
}


/**
 * Add the Vertical Align option to the toolbar
 */
function addControl( BlockEdit ) {
  return ( props ) => {
    // abort if not our targetted block
    let targetBlocks = [ 'woocommerce/featured-category', 'woocommerce/featured-product' ];
    if ( !targetBlocks.includes( props.name ) ) {
      return (
        <BlockEdit { ...props } />
      );
    }

    let atts = props.attributes;

    return (
      <Fragment>
        <BlockEdit { ...props } />
        <BlockControls key="controls">
          <BlockVerticalAlignmentToolbar
            onChange={ updateAlignment }
            value={ atts.verticalAlignment }
          />
        </BlockControls>
        <InspectorControls>
        <PanelColorSettings title="Text Color"
          initialOpen="true"
          colorSettings={ [
            {
              label: 'Text Color',
              value: atts.textColor,
              disableCustomColors: false,
              onChange: updateTextColor
            },
          ] }>
          </PanelColorSettings>
        </InspectorControls>
      </Fragment>
    );


    //
    function updateAlignment( newValue ) {
      newValue = newValue || '';
      props.setAttributes( { verticalAlignment: newValue } );

      // remove existing VAlign class
      if( atts.className ) {
        atts.className = atts.className.replace( /is-vertically-aligned-\w+/, '' );
      } else {
        atts.className = ''; // initialize
      }

      // add VAlign class
      if( newValue ) {
        props.setAttributes({ className: `${atts.className} is-vertically-aligned-${ newValue }` });
      }
    }

    /**
     *  
     */
    function updateTextColor( newColor ) {
      newColor = newColor || 'white';
      props.setAttributes({ textColor: newColor });

      // remove existing color class
      if( atts.className ) {
        atts.className = atts.className.replace( /has-text-color has-[\w-]+-color/, '' ).trim();
      } else {
        atts.className = ''; // initialize
      }
      
      // if none selected
      if( newColor === 'white' ) {
        props.setAttributes({ className: atts.className.trim() });
      }
      else {
        const settings = select( 'core/editor' ).getEditorSettings();
        const colorObject = getColorObjectByColorValue( settings.colors, newColor );

        props.setAttributes({ className: `${atts.className} has-text-color has-${colorObject.slug}-color` });
      }
    }
  };
}
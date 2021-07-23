// Add Text Alignment to all Products block

import './products.sass';
import { assign } from 'lodash';
import { addFilter } from '@wordpress/hooks';
import { Fragment } from '@wordpress/element';
import {
  BlockControls,
  AlignmentToolbar } from '@wordpress/block-editor';

addFilter( 'blocks.registerBlockType', 'wc-products/attributes', addAttributes );
addFilter( 'editor.BlockEdit', 'wc-products/edit', addControl );

/**
 * 
 */
function addAttributes( settings, name ) {
  // abort if not our targetted block
  let targetBlocks = [ 'woocommerce/handpicked-products' ];
  if ( !targetBlocks.includes( name ) ) {
    return settings;
  }
  
  // Use Lodash's assign to gracefully handle if attributes are undefined
  settings.attributes = assign( settings.attributes, {
    textAlign: { type: 'string', default: '' },
  } );

  return settings;
}

/**
 * 
 */
function addControl( BlockEdit ) {
  return ( props ) => {
    // abort if not our targetted block
    let targetBlocks = [ 'woocommerce/handpicked-products' ];
    if ( !targetBlocks.includes( props.name ) ) {
      return (
        <BlockEdit { ...props } />
      );
    }

    let atts = props.attributes;

    return (
      <Fragment>
        <BlockEdit { ...props } />
        <BlockControls>
          <AlignmentToolbar 
            onChange={ updateAlignment }
            value={ atts.textAlign } />
        </BlockControls>
      </Fragment>
    );

    //
    function updateAlignment( newValue ) {
      newValue = newValue || '';
      props.setAttributes({ textAlign: newValue });

      // remove existing alignment class
      if( atts.className ) {
        atts.className = atts.className.replace( /has-text-align-\w+/, '' ).trim();
      } else {
        atts.className = ''; // initialize
      }

      // add Align class
      if( newValue ) {
        props.setAttributes({ className: `${atts.className} has-text-align-${ newValue }` });
      }
    }
  };
}
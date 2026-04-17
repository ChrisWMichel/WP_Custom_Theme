import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls, InnerBlocks} from '@wordpress/block-editor';
import {PanelBody, RangeControl, SelectControl} from '@wordpress/components'
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js';
import './main.css';

registerBlockType('custom-plus/team-members-group', {
  icon: {
    src: icons.teamGroup
  },
  edit({ attributes, setAttributes }) {
    const { columns, imageShape } = attributes;
    const blockProps = useBlockProps({
      className: `cols-${columns}`
    });
   
    return (
      <>
        <InspectorControls>
          <PanelBody title={__('Settings', 'custom-plus')}>
            <RangeControl 
              label={__('Columns', 'custom-plus')}
              onChange={columns => setAttributes({columns})}
              value={columns}
              min={2}
              max={4}
            />
            <SelectControl 
              label={__('Image Shape', 'custom-plus')}
              value={ imageShape }
              options={[
                  { label: __('Hexagon', 'custom-plus'), value: 'hexagon' },
                  { label: __('Rabbet', 'custom-plus'), value: 'rabbet' },
                  { label: __('Pentagon', 'custom-plus'), value: 'pentagon' },
              ]}
              onChange={imageShape => setAttributes({ imageShape })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <InnerBlocks
            allowedBlocks={['custom-plus/team-member']}
            orientation='horizontal'
            renderAppender={InnerBlocks.ButtonBlockAppender}
            template={[
              ['custom-plus/team-member', {
                name: 'John Doe',
                title: 'CEO',
                bio: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                imageURL: 'https://via.placeholder.com/150',
                imageShape: 'hexagon'
              }],
              ['custom-plus/team-member'],
              ['custom-plus/team-member'],
            ]}
          />
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { columns } = attributes;
    const blockProps = useBlockProps.save({
      className: `cols-${columns}`
    });

    return (
      <div {...blockProps}>
        <InnerBlocks.Content />
      </div>
    )
  }
});
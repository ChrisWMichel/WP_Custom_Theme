import { registerBlockType } from '@wordpress/blocks';
import { RichText, useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js'
import './main.css'

registerBlockType('custom-plus/page-header', {
  icon: icons.pageHeader,
  edit:({ attributes, setAttributes }) => {
    const { content, showCategory } = attributes;
    const blockProps = useBlockProps({
      className: 'wp-block-udemy-plus-page-header',
    });

    return (
      <>
        <InspectorControls>
            <PanelBody title={__('General Settings', 'custom-plus')}>
                <ToggleControl
                    label={__('Show Category', 'custom-plus')}
                    checked={showCategory}
                    onChange={showCategory => setAttributes({ showCategory})}
                    help={
                        showCategory ?
                         __('Category will be displayed instead of the heading', 'custom-plus')  : 
                         __('Heading will be displayed instead of the category', 'custom-plus')
                    }
                />
            </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
            <div className="inner-page-header">
                {
                    showCategory ? (
                        <h1>{__('Category: Some Category', 'custom-plus')}</h1>
                    ) : (
                        <RichText
                            tagName="h1"
                            placeholder={__("Enter heading...", "custom-plus")}
                            value={content}
                            onChange={content => setAttributes({ content })}
                        />
                    )
                }
                 
            </div>
        </div>
      </>
    );
  },
  save:({ attributes }) => {
    const { content } = attributes;
    const blockProps = useBlockProps.save({
      className: "wp-block-udemy-plus-page-header",
    });
    return <RichText.Content {...blockProps} tagName="h1" value={content} />;
  },
});
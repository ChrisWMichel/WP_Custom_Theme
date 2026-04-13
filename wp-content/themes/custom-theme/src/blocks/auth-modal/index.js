import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js'
import './main.css'

registerBlockType('custom-plus/auth-modal', {
  icon: {
    src: icons.authModal
  },
  edit({ attributes, setAttributes }) {
    const { showRegister } = attributes;
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={ __('Settings', 'custom-plus') }>
            <ToggleControl
              label={ __('Show Register', 'custom-plus') }
              checked={ showRegister }
              help={ showRegister ? __('Registration form will be displayed in the modal', 'custom-plus') : __('Hiding registration form', 'custom-plus') }
              onChange={ showRegister => setAttributes({ showRegister }) }
            />
            
          </PanelBody>
        </InspectorControls>
        <div { ...blockProps }>
          {__('This block is not previewable from the editor. View your site for a live demo.', 'custom-plus')}
        </div>
      </>
    );
  },
  save() {
    return null;
  }
});
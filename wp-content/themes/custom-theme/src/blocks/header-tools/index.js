import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, CheckboxControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js'
import './main.css'

registerBlockType('custom-plus/header-tools', {
  icon: {
    src: icons.headerTools
  },
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps({
      className: 'wp-block-udemy-plus-header-tools',
    });
    const { showAuthLink } = attributes;

    return (
      <>
        <InspectorControls>
          <PanelBody title={ __('Settings', 'custom-plus') }>
            <SelectControl
              label={ __('Show Login/Register Link', 'custom-plus') }
              value={ showAuthLink }
              options={ [
                { label: __('Yes', 'custom-plus'), value: true },
                { label: __('No', 'custom-plus'), value: false },
              ] }
              onChange={ newValue => setAttributes({ showAuthLink: (newValue === 'true') }) }
            />
              
              <CheckboxControl
                label={ __('Show Login/Register Link', 'custom-plus') }
                checked={ showAuthLink }
                onChange={ showAuthLink => setAttributes({ showAuthLink }) }
                help={ showAuthLink ? __('Login/Register link will be displayed in the header', 'custom-plus') : __('Login/Register link will be hidden in the header', 'custom-plus') }
              />
          </PanelBody>
        </InspectorControls>
        <div className="wp-block-udemy-plus-header-tools" { ...blockProps }>
          { showAuthLink ?
          <a className="signin-link open-modal" href="#signin-modal">
            <div className="signin-icon">
              <i className="bi bi-person-circle"></i>
            </div>
            <div className="signin-text">
              <small>Hello, Sign in</small>
              My Account
            </div>
          </a> : null }
          
        </div>
      </>
    );
  },
  save() {
    return null;
  }
});
 import {useBlockProps, InspectorControls, RichText, MediaPlaceholder, BlockControls, MediaReplaceFlow} from '@wordpress/block-editor';
 import { __ } from '@wordpress/i18n';
 import { PanelBody, TextareaControl, Spinner, ToolbarButton} from '@wordpress/components';
 import { isBlobURL, revokeBlobURL } from '@wordpress/blob';
 import { useState } from '@wordpress/element';
 
 export default function({ attributes, setAttributes }) {
    const { 
      name, title, bio, imgID, imgAlt, imgURL, socialHandles
    } = attributes;
    const blockProps = useBlockProps();
    const [imgPreview, setImgPreview] = useState(imgURL);
    const selectImg = media => {
                let newImgURL = null;
                if(isBlobURL(media.url)){
                  newImgURL = media.url;
                } else {
                  newImgURL = media.sizes?.teamMember?.url || media.url;
                  setAttributes({ imgID: media.id, imgURL: newImgURL, imgAlt: media.alt });
                  revokeBlobURL(imgPreview);
                }
                
                setImgPreview(newImgURL);
              }
    const selectImgUrl = url => {
                setAttributes({
                  imgID: null,
                  imgAlt: null,
                  imgURL: url
                });
                setImgPreview(url);
              }

    return (
      <>
      {
            imgPreview &&
        <BlockControls group='inline'> 
            <MediaReplaceFlow
              name="Replace image"
              mediaId={imgID}
              mediaURL={imgURL}
              allowedTypes={['image']}
              accept={'image/*'}
              onError={error => console.error(error)}
              onSelect={selectImg}
              onSelectURL={selectImgUrl}
            />
            <ToolbarButton className='remove-image' onClick={() => {
              setAttributes({ imgID: null, imgURL: null, imgAlt: null });
              revokeBlobURL(imgPreview);
              setImgPreview(null);
            }}>
                {"Remove image"}
            </ToolbarButton>
        </BlockControls>
    }


        <InspectorControls>
          <PanelBody title={__('Settings', 'custom-plus')}>
            <TextareaControl 
              label={__('Alt Attribute', 'custom-plus')}
              value={imgAlt}
              onChange={imgAlt => setAttributes({imgAlt})}
              help={__(
                'Description of your image for screen readers.',
                'custom-plus'
              )}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="author-meta">
            {imgPreview && <img src={imgPreview} alt={imgAlt} />}
            {isBlobURL(imgPreview) && <Spinner />}
            <MediaPlaceholder
              onSelect={selectImg}
              allowedTypes={['image']}
              value={{ id: imgID, url: imgURL, alt: imgAlt }}
              accept={'image/*'}
              icon="admin-users"
              onError={error => console.error(error)}
              disableMediaButtons={!!imgPreview}
              onSelectURL={selectImgUrl}
            />
            <p>
              <RichText 
                placeholder={__('Name', 'custom-plus')}
                tagName="strong"
                onChange={name => setAttributes({name})}
                value={name}
              />
              <RichText 
                placeholder={__('Title', 'custom-plus')}
                tagName="span"
                onChange={title => setAttributes({title})}
                value={title}
              />
            </p>
          </div>
          <div className="member-bio">
            <RichText 
              placeholder={__('Member bio', 'custom-plus')}
              tagName="p"
              onChange={bio => setAttributes({bio})}
              value={bio}
            />
          </div>
          <div className="social-links"></div>
        </div>
      </>
    );
  }
 import {useBlockProps, InspectorControls, RichText, MediaPlaceholder, BlockControls, MediaReplaceFlow} from '@wordpress/block-editor';
 import { __ } from '@wordpress/i18n';
 import { PanelBody, TextareaControl, Spinner, ToolbarButton, Tooltip, Icon, TextControl, Button} from '@wordpress/components';
 import { isBlobURL, revokeBlobURL } from '@wordpress/blob';
 import { useState } from '@wordpress/element';
 
 export default function({ attributes, setAttributes, context, isSelected }) {
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
    const imageClass =  `wp-image-${imgID} img-${context['custom-plus/image-shape']}`;

    const [activeSocialHandle, setActiveSocialHandle] = useState(null);

    setAttributes({ imageShape: context['custom-plus/image-shape'] });

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
            {!imgPreview && !isBlobURL(imgPreview) && (
            <TextareaControl 
              label={__('Alt Attribute', 'custom-plus')}
              value={imgAlt}
              onChange={imgAlt => setAttributes({imgAlt})}
              help={__(
                'Description of your image for screen readers.',
                'custom-plus'
              )}
            />
             )}
          </PanelBody>
         
        </InspectorControls>
        
        <div {...blockProps}>
          <div className="author-meta">
            {imgPreview && <img src={imgPreview} alt={imgAlt} className={imageClass} />}
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
          <div className="social-links">
            {(socialHandles || []).map((handle, index) => (
              <a onClick={e => {
                e.preventDefault();
                setActiveSocialHandle(activeSocialHandle === index ? null : index)
              }}
              key={handle.id} href={handle.url} target="_blank" rel="noopener noreferrer"
              className={
                activeSocialHandle === index && isSelected ? 'is-active' : ''
            }
              >
                <i className={`bi bi-${handle.icon}`}></i>
              </a>
            ))}

            {
            isSelected && (
                 <Tooltip text="Add Social Media Handle">
                    <a
                    href="#"
                    onClick={(e) => {
                        e.preventDefault();
                        setAttributes({ socialHandles: [...(socialHandles || []), { icon: 'question', url: '' }] });
                        setActiveSocialHandle(socialHandles.length);
                    }}
                >
                    <i className="bi bi-plus"></i>
                    </a>
                </Tooltip>
            )}
          </div>
          {
            isSelected && activeSocialHandle !== null && 
            (<div className="team-member-social-edit-ctr">
                <TextControl
                    label="URL"
                    value={socialHandles[activeSocialHandle].url}
                    onChange={url => {
                        const tempLink = {...socialHandles[activeSocialHandle]};
                        const tempSocial = [...socialHandles];
                        tempLink.url = url;
                        tempSocial[activeSocialHandle] = tempLink;
                        setAttributes({ socialHandles: tempSocial });
                    }}
                />
                <TextControl
                    label="ICON"
                    value={socialHandles[activeSocialHandle].icon}
                    onChange={icon => {
                        const tempLink = {...socialHandles[activeSocialHandle]};
                        const tempSocial = [...socialHandles];
                        tempLink.icon = icon;
                        tempSocial[activeSocialHandle] = tempLink;
                        setAttributes({ socialHandles: tempSocial });
                    }}
                />
                <Button isDestructive onClick={() => {
                    const tempCopy = [...socialHandles];
                    tempCopy.splice(activeSocialHandle, 1);
                    setAttributes({ socialHandles: tempCopy });
                    setActiveSocialHandle(null);
                }}>
                    {__('Remove', 'custom-plus')}
                </Button>

            </div>)
          }
        </div>
      </>
    );
  }
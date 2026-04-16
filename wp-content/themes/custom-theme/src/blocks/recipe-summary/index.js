import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import {useEntityProp} from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import Rating from '@mui/material/Rating';
import { Spinner } from '@wordpress/components';
import icons from '../../icons.js';
import './main.css';

registerBlockType('custom-plus/recipe-summary', {
  icon: {
    src: icons.recipeSummary
  },
  edit({ attributes, setAttributes, context }) {
    const { prepTime, cookTime, course } = attributes;
    const blockProps = useBlockProps();
    const editorPostType = useSelect(
      ( select ) => select( 'core/editor' )?.getCurrentPostType(),
      []
    );
    const editorPostId = useSelect(
      ( select ) => select( 'core/editor' )?.getCurrentPostId(),
      []
    );

    const postType = context?.postType || editorPostType || 'recipe';
    const postId = context?.postId || editorPostId;

    const [termIDs] = useEntityProp('postType', postType, 'cuisine', postId);
    const hasCuisineSelection = Array.isArray(termIDs) && termIDs.length > 0;

    const { rating } = useSelect((select) => {
      const meta = select('core/editor').getEditedPostAttribute('meta');
      return {
        rating: meta?.recipe_rating ?? null
      }
    }, []);

    console.log('Rating:', rating);

    const { cuisines, isLoading } = useSelect((select) => {
      const { getEntityRecords, isResolving } = select('core')

      const taxonomyArgs = [
        'taxonomy', 
        'cuisine', 
        {
          include: termIDs
        }
      ];

      return {
        cuisines: getEntityRecords(...taxonomyArgs),
        isLoading: isResolving('getEntityRecords', taxonomyArgs)
      }
    }, [termIDs])

    return (
      <>
        <div {...blockProps}>
          <i className="bi bi-alarm"></i>
          <div className="recipe-columns-2">
            <div className="recipe-metadata">
              <div className="recipe-title">{__('Prep Time', 'custom-plus')}</div>
              <div className="recipe-data recipe-prep-time">
                <RichText
                  tagName="span"
                  value={ prepTime } 
                  onChange={ prepTime => setAttributes({ prepTime }) }
                  placeholder={ __('Prep time', 'custom-plus') }
                />
              </div>
            </div>
            <div className="recipe-metadata">
              <div className="recipe-title">{__('Cook Time', 'custom-plus')}</div>
              <div className="recipe-data recipe-cook-time">
                <RichText
                  tagName="span"
                  value={ cookTime } 
                  onChange={ cookTime => setAttributes({ cookTime }) }
                  placeholder={ __('Cook time', 'custom-plus') }
                />
              </div>
            </div>
          </div>
          <div className="recipe-columns-2-alt">
            <div className="recipe-columns-2">
              <div className="recipe-metadata">
                <div className="recipe-title">{__('Course', 'custom-plus')}</div>
                <div className="recipe-data recipe-course">
                  <RichText
                    tagName="span"
                    value={ course } 
                    onChange={ course => setAttributes({ course }) }
                    placeholder={ __('Course', 'custom-plus') }
                  />
                </div>
              </div>
              <div className="recipe-metadata">
                <div className="recipe-title">{__('Cuisine', 'custom-plus')}</div>
                <div className="recipe-data recipe-cuisine">
                  { !hasCuisineSelection && (
                    <span>{__('No cuisine selected', 'custom-plus')}</span>
                  ) }
                  { isLoading && <Spinner /> }
                  
                {
                  !isLoading && cuisines && cuisines.map((item, index) => {
                    const comma = index < cuisines.length - 1 ? ', ' : '';
                     return (
                      <>
                      <a href={item.meta.cuisine_more_info_url}>{item.name}</a>{comma}
                      </>
                    )
                  })
                }
              
                </div>
              </div>
              <i className="bi bi-egg-fried"></i>
            </div>
            <div className="recipe-metadata">
              <div className="recipe-title">{__('Rating', 'custom-plus')}</div>
              <div className="recipe-data">
                <Rating value={rating} readOnly />
              </div>
              <i className="bi bi-hand-thumbs-up"></i>
            </div>
          </div>
        </div>
      </>
    );
  },
  save() {
    return null;
  }
});
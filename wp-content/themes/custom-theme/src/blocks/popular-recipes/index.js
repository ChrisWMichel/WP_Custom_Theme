import { registerBlockType } from '@wordpress/blocks'
import { useBlockProps, InspectorControls, RichText} from '@wordpress/block-editor'
import { __ } from '@wordpress/i18n'
import { PanelBody, QueryControls } from '@wordpress/components'
import { useSelect } from '@wordpress/data'
import { RawHTML } from '@wordpress/element'
import icons from '../../icons.js'
import './main.css'
import { use } from 'react'

registerBlockType('custom-plus/popular-recipes', {
  icon: {
    src: icons.popularRecipes
  },
	edit({ attributes, setAttributes }) {
    const { title, count, cuisines } = attributes
    const blockProps = useBlockProps()

    const terms = useSelect(select => {
      return select('core').getEntityRecords('taxonomy', 'cuisine', {
        per_page: -1,
      })
    }, [])

    const suggestions = terms ? terms.map(term => ({ label: term.name, value: term.id })) : [];

    terms?.forEach(term => {
      suggestions[term.name] = term;
    })

    const cuisineIDs = cuisines ? cuisines.map(cuisine => cuisine.id) : [];

    const posts = useSelect(select => {
      return select('core').getEntityRecords('postType', 'recipe', {
        per_page: count,
        _embed: true,
        cuisine: cuisineIDs,
        orderby: 'meta_value_num',
        meta_key: 'recipe_rating',
        order: 'desc',
      })
    }, [count, cuisineIDs]);


    return (
      <>
        <InspectorControls>
          <PanelBody title={__('Settings', 'custom-plus')}>
            <QueryControls
              numberOfItems={ count }
              onNumberOfItemsChange={ count => setAttributes({ count }) }
              minItems={ 1 }
              maxItems={ 10 }
                categorySuggestions = { suggestions }
                onCategoryChange = {newTerms => {
                    const newCusines = []
                    newTerms.forEach(cuisine => {
                        if(typeof cuisine === 'object') {
                            newCusines.push(cuisine);
                            return;
                        }
                        const cuisineTerm = terms?.find(term => term.name === cuisine);
                        if (cuisineTerm) {
                            newCusines.push(cuisineTerm);
                        }
                    })
                    setAttributes({ cuisines: newCusines });
                }}
                selectedCategories={cuisines}

            />

          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <RichText
            tagName="h6"
            value={ title }
            withoutInteractiveFormatting
            onChange={ title => setAttributes({ title }) }
            placeholder={ __('Title', 'custom-plus') }
          />
          {
            posts?.map(post => {
              const imageUrl = post._embedded && post._embedded['wp:featuredmedia'] ? post._embedded['wp:featuredmedia'][0].source_url : '';
              const authorName = post._embedded && post._embedded.author ? post._embedded.author[0].name : '';
              return (
                <div className="single-post" key={post.id}>
                    {
                        imageUrl && <a className="single-post-image" href={post.link}>
                            <img src={imageUrl} alt={post.title.rendered} />
                        </a>
                    }
                        
                        <div className="single-post-detail">
                            <a href={post.link}><RawHTML>{post.title.rendered}</RawHTML></a>
                    <span>
                        by <a href={post._embedded && post._embedded.author ? post._embedded.author[0].link : '#'}>{authorName}</a>
                    </span>
                    </div>
                </div>
              )
              })
                
           }
          
        </div>
      </>
    );
  },
  save() {
    
    return null;
  }
});
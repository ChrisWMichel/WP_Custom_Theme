import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import { useEffect} from '@wordpress/element';
import {Spinner} from '@wordpress/components';
import icons from '../../icons.js';
import './main.css';
import { useState } from 'react';

registerBlockType('custom-plus/daily-recipe', {
  icon: {
    src: icons.dailyRecipe
  },
	edit({ attributes, setAttributes }) {
    const { title } = attributes;
    const blockProps = useBlockProps();

    const [post, setPost] = useState({
        isLoading: true,
        url: null,
        img: null,
        title: null,
      });

      useEffect(() => {
            async function fetchData() {
                const response = await apiFetch({
                    path: '/custom-plus/v1/daily-recipe' ,
                });
                setPost({
                    isLoading: false,
                    ...response,
                });
            }
            fetchData();
        }, []);
        
    return (
      <div {...blockProps}>
        <RichText
          tagName="h6"
          value={ title } 
          withoutInteractiveFormatting
          onChange={ title => setAttributes({ title }) }
          placeholder={ __('Title', 'custom-plus') }
        />
        {post.isLoading ? <Spinner /> : (
        <a href={post.url}>
          <img src={post.img} />
          <h3>{post.title}</h3>
        </a>
        )}
      </div>
    );
  },
});
import { registerBlockType } from "@wordpress/blocks"
import { RichText, useBlockProps, InspectorControls } from "@wordpress/block-editor"
import { __ } from "@wordpress/i18n"
import { PanelBody, TextControl, ColorPalette } from "@wordpress/components"
import block from "./block.json"
import "./main.css"
 
registerBlockType(block.name, {
  edit: ({ attributes, setAttributes }) => {
    const { content, underline_color } = attributes;
    const blockProps = useBlockProps({
      className: "fancy-header",
      style: {
        "--underline-color": underline_color,
      },
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Fancy Header Settings", "custom-plus")}>
            <TextControl
              __next40pxDefaultSize={true}
              __nextHasNoMarginBottom={true}
              label={__("Heading Text", "custom-plus")}
              value={content}
              onChange={(newContent) => setAttributes({ content: newContent })}
            />
            <ColorPalette
              label={__("Underline Color", "custom-plus")}
              colors={[
                { name: "Red", color: "#f87171" },
                { name: "Blue", color: "#3b82f6" },
                { name: "Green", color: "#10b981" },
              ]}
              value={underline_color}
              onChange={(newColor) => setAttributes({ underline_color: newColor })}
            />
          </PanelBody>
        </InspectorControls>
        <RichText
          {...blockProps}
          tagName="h2"
          placeholder={__("Enter heading...", "custom-plus")}
          value={content}
          onChange={(newContent) => setAttributes({ content: newContent })}
          allowedFormats={["core/bold", "core/italic", "core/underline"]}
        />
      </>
    );
  },
  save: ({ attributes }) => {
    const { content, underline_color } = attributes;
    const blockProps = useBlockProps.save({
      className: "fancy-header",
      style: {
        "--underline-color": underline_color,
      },
    });

    return <RichText.Content {...blockProps} tagName="h2" value={content} />;
  },
});
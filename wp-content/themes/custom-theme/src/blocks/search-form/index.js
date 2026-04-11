import { registerBlockType } from "@wordpress/blocks"
import { useBlockProps, PanelColorSettings, InspectorControls } from "@wordpress/block-editor"
import { PanelBody, TextControl } from "@wordpress/components"
import { __ } from "@wordpress/i18n"
import icons from "../../icons"
import block from "./block.json"
import "./main.css"

registerBlockType(block.name, {
  icon: icons.search,
  edit: ({ attributes, setAttributes }) => {
    const { bgColor, textColor, buttonText, buttonBgColor, buttonTextColor } = attributes;
    const blockProps = useBlockProps({
      className: "wp-block-udemy-plus-search-form",
      style: {
        backgroundColor: bgColor,
        color: textColor,
      },
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Button Settings", "custom-plus")} initialOpen={true}>
            <TextControl
              __next40pxDefaultSize={true}
              __nextHasNoMarginBottom={true}
              label={__("Button Text", "custom-plus")}
              value={buttonText}
              onChange={(value) => setAttributes({ buttonText: value })}
            />
          </PanelBody>

          <PanelColorSettings
            title={__("Color Settings", "custom-plus")}
            initialOpen={true}
            colorSettings={[
              {
                value: bgColor,
                onChange: (value) => setAttributes({ bgColor: value }),
                label: __("Block Background Color", "custom-plus"),
              },
              {
                value: textColor,
                onChange: (value) => setAttributes({ textColor: value }),
                label: __("Block Text Color", "custom-plus"),
              },
              {
                value: buttonBgColor,
                onChange: (value) => setAttributes({ buttonBgColor: value }),
                label: __("Button Background Color", "custom-plus"),
              },
              {
                value: buttonTextColor,
                onChange: (value) => setAttributes({ buttonTextColor: value }),
                label: __("Button Text Color", "custom-plus"),
              },
            ]}
          />
        </InspectorControls>

        <div {...blockProps}>
          <h1>Search: Your search term here</h1>
          <form>
            <input type="text" placeholder="Search" />
            <div className="btn-wrapper">
              <button
                type="submit"
                style={{
                  backgroundColor: buttonBgColor,
                  color: buttonTextColor,
                }}
              >
                {buttonText}
              </button>
            </div>
          </form>
        </div>
      </>
    );
  },
  save: ({ attributes }) => {
    const { bgColor, textColor, buttonText, buttonBgColor, buttonTextColor } = attributes;
    const blockProps = useBlockProps.save({
      className: "wp-block-udemy-plus-search-form",
      style: {
        backgroundColor: bgColor,
        color: textColor,
      },
    });

    return (
      <div {...blockProps}>
        <h1>Search: Your search term here</h1>
        <form>
          <input type="text" placeholder="Search" />
          <div className="btn-wrapper">
            <button
              type="submit"
              style={{
                backgroundColor: buttonBgColor,
                color: buttonTextColor,
              }}
            >
              {buttonText}
            </button>
          </div>
        </form>
      </div>
    );
  },
  deprecated: [
    {
      save: () => {
        const blockProps = useBlockProps.save({
          className: "wp-block-udemy-plus-search-form",
        });

        return (
          <div {...blockProps}>
            <h1>Search: Your search term here</h1>
            <form>
              <input type="text" placeholder="Search" />
              <div className="btn-wrapper">
                <button type="submit">Search</button>
              </div>
            </form>
          </div>
        );
      },
    },
  ],
});
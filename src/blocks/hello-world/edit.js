/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * WordPress dependencies
 */
import {
	/**
	 * React hook that is used to mark the block wrapper element.
	 * It provides all the necessary props like the class name.
	 *
	 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
	 */
	useBlockProps,
	RichText,
	MediaReplaceFlow,
	MediaUpload,
	MediaUploadCheck,
	BlockControls,
} from "@wordpress/block-editor";
import { ToolbarGroup, ToolbarButton } from "@wordpress/components";
import { useState } from "@wordpress/element";
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./style.scss";
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
	// Get the attributes and function to set attributes from props
	const { attributes, setAttributes } = props;
	// Get the Block Wrapper props
	const blockProps = useBlockProps();
	// Get the heading text and set up a local state for it
	const [heading, setHeading] = useState(attributes.content);
	// Get the image and set up a local state for it
	const [media, setMedia] = useState(attributes.img);

	// Set default background color
	if (!attributes.backgroundColor) {
		setAttributes({ backgroundColor: "secondary" });
	}

	// Set default text color
	if (!attributes.textColor) {
		setAttributes({ textColor: "background" });
	}

	// This is a function that is passed to the RichText component.
	// It is called when the heading text is changed.
	// It sets the local state and the attributes.
	function setHeadingContent(content) {
		setAttributes({ content: content });
		setHeading(content);
	}

	// This is a function that is passed to the MediaUpload component
	// It is called when the image is changed.
	// It sets the local state and the attributes.
	function selectImage(value) {
		setAttributes({
			img: value,
		});
		setMedia(value);
	}

	return (
		<div {...blockProps}>
			{
				// We're adding the Media Add/Replace buttons to the toolbar of the whole block as a section.
			}
			<BlockControls>
				<ToolbarGroup label={__("Media", "block-theme")}>
					{
						// If there is an image, show the replace button
						media ? (
							<>
								<MediaReplaceFlow
									mediaUrl={media?.source_url}
									onSelect={selectImage}
									name={__("Replace Image", "block-theme")}
								/>
							</>
						) : (
							// If there is no image, show the add button
							<MediaUploadCheck>
								<MediaUpload
									onSelect={selectImage}
									render={({ open }) => (
										<ToolbarButton onClick={open}>
											{__("Add Image", "block-theme")}
										</ToolbarButton>
									)}
								/>
							</MediaUploadCheck>
						)
					}
				</ToolbarGroup>
			</BlockControls>
			<div className="hello-world-image">
				<img
					src={
						// If there is an image, show it, otherwise show a placeholder
						media ? media.sizes.full.url : "https://via.placeholder.com/325x216"
					}
					alt={
						// If there is an image, show its alt text, otherwise show placeholder alt text
						media ? media.alt : "Placeholder image"
					}
				/>
			</div>
			<h3 className="hello-world-text">
				<RichText
					// This is the class name that will be added to the heading element
					className="hello-world-text"
					// This is the tag name that will be used in the editor
					tagName="h3"
					// This is the placeholder text that will be shown in the editor
					placeholder={__("Enter text..", "block-theme")}
					// If there is heading text, show it, otherwise show the placeholder
					value={heading}
					// This is the function that will be called when the heading text is changed
					onChange={setHeadingContent}
				/>
			</h3>
		</div>
	);
}

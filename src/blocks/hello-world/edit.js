/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import {
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
	const { attributes, setAttributes } = props;
	const blockProps = useBlockProps();
	const [heading, setHeading] = useState(attributes.content);
	const [media, setMedia] = useState(attributes.img);

	// Set default background color
	if (!attributes.backgroundColor) {
		setAttributes({ backgroundColor: "secondary" });
	}

	// Set default text color
	if (!attributes.textColor) {
		setAttributes({ textColor: "tertiary" });
	}

	// set the heading text
	function setHeadingContent(content) {
		setAttributes({ content: content });
		setHeading(content);
	}

	// set the image
	function selectImage(value) {
		console.log(value);
		setAttributes({
			img: value,
		});
		setMedia(value);
	}

	return (
		<div {...blockProps}>
			<BlockControls>
				<ToolbarGroup label={__("Media", "tangent")}>
					{media ? (
						<>
							<MediaReplaceFlow
								mediaUrl={media?.source_url}
								onSelect={selectImage}
								name={__("Replace Image", "tangent")}
							/>
						</>
					) : (
						<MediaUploadCheck>
							<MediaUpload
								onSelect={selectImage}
								render={({ open }) => (
									<ToolbarButton onClick={open}>
										{__("Add Image", "tangent")}
									</ToolbarButton>
								)}
							/>
						</MediaUploadCheck>
					)}
				</ToolbarGroup>
			</BlockControls>
			<div className="hello-world-image">
				<img
					src={
						media ? media.sizes.full.url : "https://via.placeholder.com/325x216"
					}
					alt={media ? media.alt : "Placeholder image"}
				/>
			</div>
			<h3 className="hello-world-text">
				<RichText
					className="hello-world-text"
					tagName="h3"
					placeholder={__("Enter text..", "viewsource-blocks")}
					value={heading}
					onChange={setHeadingContent}
				/>
			</h3>
		</div>
	);
}

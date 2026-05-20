import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';

export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			<span className="wp-post-views-count">
				<span className="count-placeholder">1,234</span>
			</span>
		</div>
	);
}

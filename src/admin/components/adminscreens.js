/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Spinner,
	Card,
	CardBody,
	TextControl
} from '@wordpress/components';


const OptionsPage = () => {
	return (
		<div>
			<h1>{ __( 'Options Page', 'wop' ) }</h1>
			<Card>
				<CardBody>
					<TextControl
						label={ __( 'Custom Field', 'wop' ) }
						help={ __( 'This is a custom field.', 'wop' ) }
					/>
				</CardBody>
			</Card>
		</div>
	);
};


export default OptionsPage;
import { __ } from '@wordpress/i18n';
import React from 'react';
import { createRoot } from 'react-dom/client';
import OptionsPage from './components/adminscreens';

const domNode = document.getElementById('wppv-admin-page');
if( domNode ) {
	createRoot( domNode ).render( <OptionsPage /> )
}
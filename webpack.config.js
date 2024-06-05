const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
module.exports = {
	...defaultConfig,
	entry: {
		admin: './src/admin',
		// plugin:'./src/plugin',
	},
	resolve: {
        extensions: ['.js', '.jsx'], // Ensure both .js and .jsx files are resolved
    },
};
/**
 * WordPress Dependencies
 */

path = require('path')
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

module.exports = {
    ...defaultConfig,
    ...{
        // Add any overrides to the default here.
        resolve:{
           
            alias: {
                '@': path.resolve(__dirname,'./src')
            }
        }
    }
}
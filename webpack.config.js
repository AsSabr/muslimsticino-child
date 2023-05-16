const path = require('path');
const MiniCssExtractPlugin  = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserWebpackPlugin = require('terser-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');

const JS_DIR = path.resolve( __dirname, 'src/js' );
const FONTS_DIR = path.resolve( __dirname, 'src/fonts' );
const IMG_DIR = path.resolve( __dirname, 'src/img' );
const ICONS_DIR = path.resolve( __dirname, 'src/icons' );
const BUILD_DIR = path.resolve( __dirname, 'build' );

let mode = 'development';

if (process.env.NODE_ENV === 'production') {
    mode = 'production'
}
console.log(mode + ' mode')

module.exports = {
    mode: mode,

    entry: {
        app: './src/js/app.js',
        // single: JS_DIR + '/single.js',
        // dashboard: JS_DIR + '/dashboard.js',
    },

    output: {
        path: BUILD_DIR,
        filename: './js/[name].min.js',
        clean: true,
    },

    devServer: {
        open: true,
        static: {
            directory: './src',
            watch: true
        }
    },

    devtool: 'source-map',

    optimization: {
        // minimize: true,
        minimizer: [
            new CssMinimizerPlugin({
                minimizerOptions: {
                    preset: [
                        "default",
                        {
                            discardComments: {removeAll: true}
                        }
                    ]
                }
            }),
            new TerserWebpackPlugin({
                terserOptions: {
                    format: {
                        comments: false,
                    }
                },
                extractComments: false,
            })
        ],
        // splitChunks: {
        //     chunks: 'all',
        // },
    },

    plugins: [
        new MiniCssExtractPlugin({
            filename: './css/[name].min.css'
        }),

        new CopyPlugin({
            patterns: [
                { from: IMG_DIR, to: BUILD_DIR + '/img' },
                { from: ICONS_DIR, to: BUILD_DIR + '/icons' },
            ],
        }),

        new DependencyExtractionWebpackPlugin( {
            injectPolyfill: true,
            combineAssets: true,
        } ),
    ],

    module: {
        rules: [
            {
                test: /\.m?js$/,
                include: [ JS_DIR ],
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    // options: {
                    //     presets: ['@babel/preset-env']
                    // }
                }
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    // (mode === 'development') ? "style-loader" : MiniCssExtractPlugin.loader,
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    {
                        loader: "postcss-loader",
                        options: {
                            postcssOptions: {
                                plugins: [
                                    [
                                        "postcss-preset-env",
                                        {
                                            browsers: 'last 5 versions'
                                        },
                                    ],
                                ],
                            },
                        },
                    },
                    "group-css-media-queries-loader",
                    "sass-loader",
                ],
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif|webp)$/i,
                exclude: [ ICONS_DIR, FONTS_DIR ],
                type: 'asset/resource',
                generator: {
                    filename: './img/[name][ext][query]'
                }
            },
            {
                test: /\.(png|svg|webp)$/i,
                exclude: [ IMG_DIR, FONTS_DIR ],
                type: 'asset/resource',
                generator: {
                    filename: './icons/[name][ext][query]'
                }
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf|svg)$/i,
                exclude: [ ICONS_DIR ],
                type: 'asset/resource',
                generator: {
                    filename: './fonts/[name][ext][query]'
                }
            },
        ]
    },
    externals: {
        jquery: 'jQuery'
    }
}

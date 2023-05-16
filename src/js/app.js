// Libs
import './libs/index';

// Custom functions
import * as customFunctions from './modules/functions';

customFunctions.copyrightLink();

// find jet navbar and add custom class for styling
let jetNav = document.querySelector('.jet-nav-wrap');
jetNav.classList.add("lmt_nav");

// Styles
import '../scss/index.scss';

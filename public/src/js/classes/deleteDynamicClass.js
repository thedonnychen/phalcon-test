import PagesClass from './PagesClass';
import HomeClass from './HomeClass';

// Use ES6 Object Literal Property Value Shorthand to maintain a map
// where the keys share the same names as the classes themselves
const classes = {
    PagesClass,
    HomeClass
};

export default class DynamicClass {
    constructor (className, opts) {
        return ( typeof classes[className] !== 'undefined' ) ? new classes[className](opts) : false;
    }
}
import {pluralize} from "numeralize-ru";

function declination(count, allowOne = false) {
    if (count > 1) {
        return `${count} ${pluralize(count, 'вид', 'вида', 'видов')}`;
    } else if (allowOne) {
        return '1 вид';
    }

    return null;
}

export default () => ({
    declination,
})

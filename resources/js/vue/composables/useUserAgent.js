const isSafari = () => navigator.userAgent.indexOf('Safari') > -1 && navigator.userAgent.indexOf('Chrome') <= -1;

export default () => ({
    isSafari
});

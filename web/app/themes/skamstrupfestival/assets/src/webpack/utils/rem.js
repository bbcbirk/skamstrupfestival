/**
 * rem
 * custom postcss function to calculate and return the font-size in rem, given a pixel value.
 * Useful in cases where the design offers the values in pixels.
 */
const rem = (pxSize, rootEmSize) => {
  rootEmSize = rootEmSize || 18;
  rootEmSize = parseInt(rootEmSize);
  pxSize = pxSize || 18;

  if (Object.prototype.toString.call(pxSize) === '[object String]') {
    pxSize = pxSize.replace(/px/gi, ''); /* strip out `px` from the string, if it is present. */
  }

  pxSize = parseInt(pxSize);

  return `${pxSize / rootEmSize}rem`;
};

module.exports = rem;

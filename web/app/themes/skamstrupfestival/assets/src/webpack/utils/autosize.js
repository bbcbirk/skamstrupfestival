/**
 * Based on: https://css-tricks.com/linearly-scale-font-size-with-css-clamp-based-on-the-viewport/ & https://xgkft.csb.app/
 * autosize
 * custom postcss function to dynamically insert a `clamp()` value
 * and dynamically calculate the font-size based on the viewport dimensions.
 */
const autosize = (viewMin, viewMax, sizeMin, sizeMax, rootEmSize) => {
  viewMin = viewMin / rootEmSize;
  viewMax = viewMax / rootEmSize;

  sizeMin = sizeMin / rootEmSize;
  sizeMax = sizeMax / rootEmSize;

  const slope = (sizeMax - sizeMin) / (viewMax - viewMin);

  const yAxis = -viewMin * slope + sizeMin;

  return `clamp(${sizeMin}rem, ${yAxis}rem + ${slope * 100}vw, ${sizeMax}rem)`;
};

module.exports = autosize;

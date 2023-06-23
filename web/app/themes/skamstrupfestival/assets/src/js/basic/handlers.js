import { handlerEscapeKeyUp } from './handle-escape-key-up';

export const handlers = ($) => {
  document.addEventListener('keyup', keyUp);
};

/**
 * Add listener for keyup events
 * @param {*} e
 */
export const keyUp = (e) => {
  e = e || window.event;

  if (e.key === 'Escape') {
    console.log({
      msg: `${e.key} was pressed.`,
      key: e.key,
    });

    // handle the event
    handlerEscapeKeyUp();
  }
};

export default handlers;

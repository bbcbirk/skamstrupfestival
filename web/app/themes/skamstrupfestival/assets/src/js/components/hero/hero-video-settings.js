/**
 * Hero video settings
 */
const heroVideoSettings = ($) => {
  'use strict';

  const $video = document.getElementById('hero-video');
  const $hero = $('.hero--with-video');
  const $playButton = $('.play-button');
  const $muteButton = $('.mute-button');

  $playButton.on('click', function () {
    $hero.toggleClass('video-playing');

    if (!$hero.hasClass('video-playing')) {
      $video.pause();
    } else if ($hero.hasClass('video-playing')) {
      $video.play();
    }
  });

  $muteButton.on('click', function () {
    $hero.toggleClass('video-muted');

    if ($hero.hasClass('video-muted')) {
      $video.muted = true;
    } else if (!$hero.hasClass('video-muted')) {
      $video.muted = false;
    }
  });
};

export default heroVideoSettings;

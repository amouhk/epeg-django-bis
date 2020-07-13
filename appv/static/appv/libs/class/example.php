<?php
/*require 'Thumbnail_Extractor.php';
require 'Thumbnail_Joiner.php';
 
// where ffmpeg is located, such as /usr/sbin/ffmpeg
$ffmpeg = '/home/epegobel/ffmpeg-build/ffmpeg';
 
// the input video file
$video = '/home/epegobel/public_html/ressources/gallery/Video/Toto/VIDEO_00209.mp4';
 
// extract one frame at 10% of the length, one at 30% and so on
$frames = array('10%', '30%', '50%', '70%', '90%');
 
// set the delay between frames in the output GIF
$joiner = new Thumbnail_Joiner(50);
// loop through the extracted frames and add them to the joiner object
foreach (new Thumbnail_Extractor($video, $frames, '200x120', $ffmpeg) as $key => $frame) {
    $joiner->add($frame);
}
$joiner->save('/home/epegobel/public_html/ressources/gallery/Video/Toto/out.gif');*/
phpinfo();
?>
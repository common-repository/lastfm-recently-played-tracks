<?php
/*
Plugin Name: Last.fm Recently Played Tracks
Plugin URI: http://ijustin.org/last-fm-widget
Description: Last.fm widget that supports customization for showing album art, how many tracks, and username. More customization to come soon! Shows track name, artist, and time played. Can also show user picture, tracks played, etc. No pesky "Support us" links.
Author: Justin Turner
Version: 1.2.0
Author URI: http://ijustin.org/
License: GPL2
*/
/*  Copyright 2010 Justin Turner (email : j.turner@ijustin.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here: 
    http://www.gnu.org/licenses/gpl-2.0.html
*/
//this is the function that gathers the data from last.fm and styles it
function fetch_ijlastfm_data($username = 'just_in_time90',$trackNum = 3,$showArt = 1,$showUI = 1,$useReturn = 0){
$options = get_option("ij_lastfm_widget");
libxml_use_internal_errors(true);
if (!is_array($options))
{
$options = array(
		'title' => 'Last.fm Recently Played',
		'username' => 'just_in_time90',
		'trackNum' => '3',
		'showArt' => '1',
		'showUI' => '1',
		'profileLink' => 'View My Profile'
      );
}
if(false === ($latest = get_transient('ij_lastfm_widget_'.$username))){
$request_url = "http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=".$username."&limit=50&api_key=f02d8c8d50cd86d57bed580b6c6aeda3";
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $request_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$latest = curl_exec($ch);
curl_close($ch);
set_transient('ij_lastfm_widget_'.$username, $latest, 60);
}
if(false === ($ui = get_transient('ij_lastfm_widget_uinfo_'.$username))){
$request_url = "http://ws.audioscrobbler.com/2.0/?method=user.getinfo&user=".$username."&api_key=f02d8c8d50cd86d57bed580b6c6aeda3";
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $request_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$ui = curl_exec($ch);
curl_close($ch);
set_transient('ij_lastfm_widget_uinfo_'.$username, $ui, 60);
}

$latest = new SimpleXMLElement($latest);
$ui = new SimpleXMLElement($ui);
if($latest->xpath('//track')){
//gather user info
$upic = $ui->user->image[1];
$username = $ui->user->name;
$playcount = $ui->user->playcount;
$timejoin = $ui->user->registered['unixtime'];
$fromCountry = $ui->user->country;

$theTracks = "";

if($showUI==1){
$theTracks = $theTracks."<div class=\"lastfm_container user\">";
if($upic!=''){
$theTracks = $theTracks."<img src=\"".$upic."\" alt=\"Profile Pic for ".$username."\"/>";
}
//determin link text
if($options['profileLink'] == "")
{
$profileLink = "View My Profile";
}else{
$profileLink = $options['profileLink'];
}
$theTracks = $theTracks."<span class=\"lastfm_user_name\">".$username."</span>";
$theTracks = $theTracks."<span class=\"lastfm_user_info\"><a href=\"http://last.fm/user/".$username."\">".$profileLink."</a></span>";
$theTracks = $theTracks."<span class=\"lastfm_user_info\">".$playcount." plays since ".date("F j Y",(int)$timejoin)."</span>";
$theTracks = $theTracks."</div>";
}
$i=0;
foreach($latest->xpath('//track') as $track){
//get all the info
	$title = $track->xpath('//name');
	$title = $title[$i];
	$nowPlaying = $track->xpath('//track/@nowplaying');
	$datePlayed = $track->xpath('//date/@uts');
	$albumArt = $track->xpath('//image[@size="medium"]');
	$artist = $track->xpath('//artist');
//create the DIV
$theTracks = $theTracks."<div class=\"lastfm_container track\">";
	if($showArt==1){
//do we want to show album art?
	if($albumArt[$i] != ""){
	$theTracks = $theTracks."<img src='".$albumArt[$i]."'  width='52' height='52' alt='Album Art for ".$title."'/>";
	}else{
	$theTracks = $theTracks."<img src='http://cdn.last.fm/flatness/catalogue/noimage/2/default_artist_medium.png' width='52' height='52' alt='No Album Art Available'/>";
	}
	$theTracks = $theTracks."<span class=\"lastfm_track_title\">".$title."</span>";
	$theTracks = $theTracks."<span class=\"lastfm_track_artist\">".$artist[$i]."</span>";
	//lets see if this song is currently playing...
	if($nowPlaying[$i] != ""){
	$theTracks = $theTracks."<span class=\"lastfm_track_info now_playing\"><img src=\"".WP_PLUGIN_URL."/lastfm-recently-played-tracks/images/icon_eq.gif\"/>now playing!</span>";
	}else{
	$theTracks = $theTracks."<span class=\"lastfm_track_info\">".human_time_diff($datePlayed[$i])." ago</span>";
	}
	}else{
	$theTracks = $theTracks."<span class=\"lastfm_track_info\">".$title."</span>";
	$theTracks = $theTracks."<span class=\"lastfm_track_artist\">".$artist[$i]."</span>";
	//lets see if this song is currently playing...
	if($nowPlaying[$i] != ""){
	$theTracks = $theTracks."<span class=\"lastfm_track_info now_playing\"><img src=\"".WP_PLUGIN_URL."/lastfm-recently-played-tracks/images/icon_eq.gif\"/>now playing!</span>";
	}else{
	$theTracks = $theTracks."<span class=\"lastfm_track_info\">".human_time_diff($datePlayed[$i])." ago</span>";
	}
}
	$i++;
$theTracks = $theTracks."</div>";
	if($i == $trackNum){break;};
	if($i == 50){break;};
}
}else{
	$theTracks = "<span class=\"lastfm_track_info\">Something went wrong... Last.fm may be down.</span>";
}
If($useReturn == 1){
return $theTracks;
}else{
echo $theTracks;
}
}
//this function is the actual widget that the end-user sees
function ij_lastfm_widget($args){
extract($args);
  $options = get_option("ij_lastfm_widget");
if (!is_array($options))
{
$options = array(
		'title' => 'Last.fm Recently Played',
		'username' => 'just_in_time90',
		'trackNum' => '3',
		'showArt' => '1',
		'showUI' => '1',
		'profileLink' => 'View My Profile'
      );
}
if(!isset($before_widget)){
$before_widget = "<div class=\"ijlastmwidget\">";
}
if(!isset($after_widget)){
$after_widget = "</div>";
}
if(!isset($before_title)){
$before_title = "<h2>";
}
if(!isset($after_title)){
$after_title = "</h2>";
}
echo $before_widget;
echo $before_title.stripslashes($options['title']).$after_title;
fetch_ijlastfm_data($options['username'], $options['trackNum'], $options['showArt'], $options['showUI']);
echo $after_widget;
}
//SHORTCODE
function ij_lastfm_shortcode($atts){
$options = get_option("ij_lastfm_widget");
if (!is_array($options))
{
$options = array(
		'title' => 'Last.fm Recently Played',
		'username' => 'just_in_time90',
		'trackNum' => '3',
		'showArt' => '1',
		'showUI' => '1',
		'profileLink' => 'View My Profile'
      );
}
extract(shortcode_atts(array(
		'username' => $options['username'],
		'tracks' => $options['trackNum'],
		'albumart' => $options['showArt'],
		'userinfo' => $options['showUI']
	), $atts));
	$result = "<p>";
	$result = $result.fetch_ijlastfm_data(wp_specialchars($username), wp_specialchars($tracks), wp_specialchars($albumart), wp_specialchars($userinfo), 1);
	$result = $result."</p>";
	return $result;
};
//this is the control panel of the widget as seen on widget page
function ij_lastfm_widget_control()
{
  $options = get_option("ij_lastfm_widget");
if (!is_array($options))
{
$options = array(
		'title' => 'Last.fm Recently Played',
		'username' => 'just_in_time90',
		'trackNum' => '3',
		'showArt' => '1',
		'showUI' => '1',
		'profileLink' => 'View My Profile'
      );
}
if ($_POST['ij_lastfm_widget-Submit'])
	{
		$options['title'] = htmlspecialchars($_POST['ij_lastfm_widget-title']);
		$options['username'] = htmlspecialchars($_POST['ij_lastfm_widget-username']);
		$options['trackNum'] = htmlspecialchars($_POST['ij_lastfm_widget-trackNum']);
		$options['showArt'] = htmlspecialchars($_POST['ij_lastfm_widget-showArt']);
		$options['showUI'] = htmlspecialchars($_POST['ij_lastfm_widget-showUI']);
		$options['profileLink'] = htmlspecialchars($_POST['ij_lastfm_widget-profileLink']);
		update_option("ij_lastfm_widget", $options);
	}
 
?>
<h3>Main Options</h3>
  <p>
    <label for="ij_lastfm_widget-title">Widget title:</label>
    <input type="text" id="ij_lastfm_widget-title" name="ij_lastfm_widget-title" style="width:100%" value="<?php echo stripslashes($options['title']);?>" />
  </p>
  <p>
    <label for="ij_lastfm_widget-username">Last.fm username:</label>
    <input type="text" id="ij_lastfm_widget-username" name="ij_lastfm_widget-username" style="width:100%" value="<?php echo stripslashes($options['username']);?>" />
  </p>
  <p>
    <label for="ij_lastfm_widget-profileLink">Profile Link Text:</label>
    <input type="text" id="ij_lastfm_widget-profileLink" name="ij_lastfm_widget-profileLink" style="width:100%" value="<?php echo stripslashes($options['profileLink']);?>" />
  </p>
  <p>
    <label for="ij_lastfm_widget-trackNum">Number of tracks:</label>
<select id="ij_lastfm_widget-trackNum" name="ij_lastfm_widget-trackNum">
<?php
$x = 1;
do{
	echo "<option value=\"".$x."\"";
	if($options['trackNum']==$x){
		echo " selected=\"selected\"";
	};
	echo ">".$x."</option>";
	$x++;
}while($x > 0 && $x < 51)
?>
  </select>
  </p>
<p>
    <label for="ij_lastfm_widget-showArt">Show album art:</label>
<?php
if($options['showArt'] == 1){
?>
	<input type="checkbox" name="ij_lastfm_widget-showArt" value="1" checked />
<?php
}else{
?>
	<input type="checkbox" name="ij_lastfm_widget-showArt" value="1" />
<?php
}
?>
</p>
<p>
    <label for="ij_lastfm_widget-showUI">Show user info:</label>
<?php
if($options['showUI'] == 1){
?>
	<input type="checkbox" name="ij_lastfm_widget-showUI" value="1" checked />
<?php
}else{
?>
	<input type="checkbox" name="ij_lastfm_widget-showUI" value="1" />
<?php
}
?>
  </p>
<input type="hidden" id="ij_lastfm_widget-Submit" name="ij_lastfm_widget-Submit" value="1" />
<?php
}
//this function registers the widget and control panel
function ij_lastfmWidget_init()
{
  register_sidebar_widget('Last.fm Widget','ij_lastfm_widget');
  register_widget_control('Last.fm Widget','ij_lastfm_widget_control',250,200);
}
//queue the stylesheet
add_action('wp_print_styles', 'add_ij_lf_stylesheet');
function add_ij_lf_stylesheet() {
	$myStyleUrl = WP_PLUGIN_URL . '/lastfm-recently-played-tracks/main.css';
	$myStyleFile = WP_PLUGIN_DIR . '/lastfm-recently-played-tracks/main.css';
		if ( file_exists($myStyleFile) ) {
			wp_register_style('mainstyle', $myStyleUrl);
			wp_enqueue_style( 'mainstyle');
		}
	$myStyleUrl = WP_PLUGIN_URL . '/lastfm-recently-played-tracks/custom.css';
	$myStyleFile = WP_PLUGIN_DIR . '/lastfm-recently-played-tracks/custom.css';
		if ( file_exists($myStyleFile) ) {
			wp_register_style('customstyle', $myStyleUrl);
			wp_enqueue_style( 'customstyle');
		}
}
//this function loads everything
add_action("plugins_loaded", "ij_lastfmWidget_init");
add_shortcode('lastfm', 'ij_lastfm_shortcode');
?>
<?php
/*
 * ScratchWiki-Toolboxes extension for MediaWiki
 * adds some useful toolboxes to the ScratchWiki
 *
 * Copyright 2013, Jonatan Mosner
 * MIT Licensed
 * http://opensource.org/licenses/MIT
 *
 */


if (!defined('MEDIAWIKI')) {
    die();
}

$box = "";

// credits for Special:Version
$wgExtensionCredits['ScratchWikiBoxes'][] = array(
	'path' => __FILE__,
	'name' => 'Scratch-Wiki Toolboxes',
	'description' => 'adds some useful toolboxes to the ScratchWiki',
	'version' => '0.1',
	'author' => 'Jonatan Mosner',
	'url' => 'https://github.com/joooni/mw-ScratchWikiBoxes', 
);


// first thing we do is creating the box content using ParserFunctions
$wgHooks['ParserFirstCallInit'][] = 'serviceboxHook';
 
// set file for multilanguage strings
$wgExtensionMessagesFiles['ExampleExtension'] = dirname( __FILE__ ) . '/ScratchWikiBoxes.i18n.php';
 
// this defines the parsing hook
function serviceboxHook( &$parser ) {
	$parser->setFunctionHook( 'sk', 'serviceboxParsing' );
	return true;
}
 
// this renders the box code using the pasing hooks params
function serviceboxParsing( $parser, $param1 = '', $param2 = '' ) {

	global $box;
 
	if ($box == "" && $param1 != "" && $param2 != "" ) {
		$box  = "<ul class='box-content'><li class='serviceBox'><a href='Scratch-Wiki:Einf%C3%BCgen_eines_Scratch-Dach-Wiki-Links_ins_Forum' title='Scratch-Wiki:Einfügen eines Scratch-Dach-Wiki-Links ins Forum'>Code zum Einbinden ins Forum</a>:";
		$box .= "<input type='text' value='[url=http://scratch-dach.info/wiki/" .$param1. "]" .$param1. "[/url]' id='forumLink' readonly></input><p></p>";
		$box .= "</li><li class='serviceBox'>Dieser Artikel im US-Scratch-Wiki:</li><li class='serviceBox'>";
		$box .= "<i><a rel='nofollow' class='external text' href='http://wiki.scratch.mit.edu/wiki/" .$param2. "'>" .$param2. "</a></i></li></ul></li></ul>";
    }
	else if ($box == "" && $param1 != "") {
		$box  = "<ul class='box-content'><li class='serviceBox'><a href='Scratch-Wiki:Einf%C3%BCgen_eines_Scratch-Dach-Wiki-Links_ins_Forum' title='Scratch-Wiki:Einfügen eines Scratch-Dach-Wiki-Links ins Forum'>Code zum Einbinden ins Forum</a>:";
		$box .= "<input type='text' value='[url=http://scratch-dach.info/wiki/" .$param1. "]" .$param1. "[/url]' id='forumLink' readonly></input>";
		$box .= "</li><ul>";
    }
 
	// return an empty string in order to not display the box in the content area
	return "";
}


// next we add the box to the sidebar
$wgHooks['SkinBuildSidebar'][] = 'servicebox';

function servicebox ($skin, &$bar) {
	global $box;
	
	// if there was no code created (no parsing string in the wiki page) don't create a new box
	if ($box != "")
		$bar['Servicekasten'] = $box;
		
	return true;
}


// and finally attach the js and css to the page
$wgExtensionFunctions[] = 'swbSetup';
 
function swbSetup () {
    global $wgOut;
    $wgOut->addModules('ext.scratchWikiBoxes');
}

$wgResourceModules['ext.scratchWikiBoxes'] = array(
    'scripts' => 'ScratchWikiBoxes.js',
    'styles' => 'ScratchWikiBoxes.css',
    'localBasePath' => __DIR__,
    'remoteExtPath' => 'ScratchWikiBoxes'
);
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

// credits
$wgExtensionCredits['ScratchWikiBoxes'][] = array(
 
   // The full path and filename of the file. This allows MediaWiki
   // to display the Subversion revision number on Special:Version.
   'path' => __FILE__,
 
   // The name of the extension, which will appear on Special:Version.
   'name' => 'Scratch-Wiki Toolboxes',
 
   // A description of the extension, which will appear on Special:Version.
   'description' => 'adds some useful toolboxes to the ScratchWiki',
 
   // The version of the extension, which will appear on Special:Version.
   // This can be a number or a string.
   'version' => '0.1', 
 
   // Your name, which will appear on Special:Version.
   'author' => 'Jonatan Mosner',
 
   // The URL to a wiki page/web page with information about the extension,
   // which will appear on Special:Version.
   'url' => 'https://github.com/joooni/mw-ScratchWikiBoxes',
 
);


// Specify the function that will initialize the parser function.
$wgHooks['ParserFirstCallInit'][] = 'serviceboxHook';
 
// Allow translation of the parser function name
$wgExtensionMessagesFiles['ExampleExtension'] = dirname( __FILE__ ) . '/ScratchWikiBoxes.i18n.php';
 
// Tell MediaWiki that the parser function exists.
function serviceboxHook( &$parser ) {
 
   // Create a function hook associating the "example" magic word with the
   // ExampleExtensionRenderParserFunction() function. See: the section 
   // 'setFunctionHook' below for details.
   $parser->setFunctionHook( 'sk', 'serviceboxParsing' );
 
   // Return true so that MediaWiki continues to load extensions.
   return true;
}
 
// Render the output of the parser function.
function serviceboxParsing( $parser, $param1 = '', $param2 = '' ) {

	global $box;
	
	echo "parsing";
 
	// The input parameters are wikitext with templates expanded.
	// The output should be wikitext too.
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
 
	return "";
}



$wgHooks['SkinBuildSidebar'][] = 'servicebox';

function servicebox ($skin, &$bar) {
	global $box;
	
	if ($box != "")
		$bar['Servicekasten'] = $box;

	/*
	$bar['Servicekasten'] = "<ul class='box-content'><li><a href='Scratch-Wiki:Einf%C3%BCgen_eines_Scratch-Dach-Wiki-Links_ins_Forum'>Code zum Einbinden ins Forum</a>:";
	$bar['Servicekasten'] += "<ul><li><i>[url=http://scratch-dach.info/wiki/{{FULLPAGENAME}}]{{PAGENAME}}[/url]</i></li></ul>";
	$bar['Servicekasten'] += "</li></ul>";
	
	/*
		'<ul>'
		 + '<li>'
			 + '<a href="Scratch-Wiki:Einf%C3%BCgen_eines_Scratch-Dach-Wiki-Links_ins_Forum" title="Scratch-Wiki:Einfügen eines Scratch-Dach-Wiki-Links ins Forum">Code zum Einbinden ins Forum</a>:'
			 + '<ul>'
				 + '<li>'
					 + '<i>[url=http://scratch-dach.info/wiki/{{FULLPAGENAME}}]{{PAGENAME}}[/url]</i>'
				 + '</li>'
			 + '</ul>'
		 + '</li>'
	 + '</ul>';
	 
	 */
	return true;
}


$wgExtensionFunctions[] = 'swbSetup';
 

// Make wiki load resources

function swbSetup () {
    global $wgOut;
    $wgOut->addModules('ext.scratchWikiBoxes');
}


// Define resources

$wgResourceModules['ext.scratchWikiBoxes'] = array(
    'scripts' => 'ScratchWikiBoxes.js',

    'styles' => 'ScratchWikiBoxes.css',

    'dependencies' => array(),

    // Where the files are
    'localBasePath' => __DIR__,
    'remoteExtPath' => 'ScratchWikiBoxes'
);
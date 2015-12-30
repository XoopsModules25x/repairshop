<?php
// $Id: tabs.php,v 1.1 2005/05/04 08:41:03 pemen Exp $
//  ------------------------------------------------------------------------ //
//                No-Ah - PHP Content Architecture Stem                      //
//                    Copyright (c) 2004 KERKNESS.C                          //
//                       <http://noah.tetrasi.com/>                          //
//                          A XOOPS.org Module                               //
//  ------------------------------------------------------------------------ //
// ------------------------------------------------------------------------- //



/**
* Class XoopsTabs is a simple class that lets you build tab menus
* @author	fatman	email: noah >4T< kerkness >D0T< ca
*/
class XoopsTabs
{

/**
 * an array of tabs
 * @var array   $tabs   
 */
 var	$tabs=array();

/**
 * an array of sublinks to display under an active tab
 * @var array   $tabs   
 */
 var	$subs=array();

/**
 * the name of the current tab
 * @var string  $current_tab    
 */
 var $current_tab;

/**
 * the name of the current sub link
 * @var string  $current_sub    
 */
 var $current_sub;

/**
 * This is a name used in your style sheet
 * @var string  $_style    
 */
 var $_style;

/**
 * set to true if build in style sheet is to be used    
 * @var bool  $_return_style	
 */
 var $_return_style = true;

/**
 * Provides a way to add some text to far right side of tabs
 * @var string  $_righttext     set this to plain text to show far right side of tabs
 */
 var $_righttxt = "XoopsTabs";

/**
* XoopsTabs class constructor 
*/
 function XoopsTabs( $style = 'xtabs' )
 {
   $this->_style = $style;
    if ( $this->_style != 'xtabs' ) {
   	$this->_return_style = false;
	}
 }

/**
 * Returns array of tabs
 * @param   void
 */
 function getTabs()
 {
  return $this->tabs;
 }

/**
 * Returns array of sub tabs
 * @param   void
 */
 function getSubs()
 {
  return $this->subs;
 }

/**
 * Returns a multidimensional array of tabs with active tab info and current sub links
 * @param   void
 */
 function getSet()
 {
  return $this->fetchTabSet();
 }

 /**
  * Print the tabs to the browser
  */
 function display()
 {
   print $this->render();
 }

 /**
  * Assigns the html for all tabs to a single smarty tag.
  */
 function assign()
 {
 	global $xoopsTpl;
   $xoopsTpl->assign( $this->_style, $this->render() );
 }
 
/**
 * Method for setting the current tab or sub tab
 * @param	string	$name	name of the current link
 * @param	string	$set	either 'tabs' or 'subs' 
 */
 function setCurrent( $name, $set='tabs' )
 {
  if ( $set == 'tabs' ){
   $this->current_tab = $name;
  }
  if ( $set == 'subs' ){
   $this->current_sub = $name;
  }
 }

 /**
  * Returns the name of the current tab
  * @return string
  */
 function getCurrent()
 {
     return $this->current_tab;
 }

/**
 * Method to add a single tab
 * @param	string	$name	a unique name for your link
 * @param	string	$link	the url for your link 
 * @param	string	$label	the text to display for link
 * @param	string	$weight	the display order ****   <--  doesn't do anything yet	
 */
 function addTab( $name, $link, $label, $weight=10 )
 {
  $this->addSet( 'tabs', $name, $link, $label, $weight );
 }

/**
 * Method to add multiple tabs from an array of data
 * @param	array	$tabs 
 */
 function addTabArray( $tabs )
 {
  foreach ( $tabs as $name=>$tab )
  {
   $this->addSet( 'tabs', $name, $tab['link'], $tab['label'], $tab['weight'] );
  }
 }

/**
 * Method to add a single sub link for display below an active tab
 * @param	string	$name	a unique name for your link
 * @param	string	$link	the url for your link 
 * @param	string	$label	the text to display for link
 * @param	string	$weight	the display order ****   <--  doesn't do anything yet	
 * @param	string	$parent	the name of the tab which this sublink should display under
 */
 function addSub( $name, $link, $label, $weight, $parent )
 {
  $this->addSet( 'subs', $name, $link, $label, $weight, $parent );
 }

/**
 * Method to add multiple sub links from an array of data
 * @param	array	$subs 
 */
 function addSubArray( $subs )
 {
  foreach ( $subs as $name=>$sub )
  {
   $this->addSet( 'subs', $name, $tab['link'], $tab['label'], $tab['weight'] );
  }
 }

/**
 * Method is used by the addTab and addSub methods and should not be called directly
 */
 function addSet( $set, $name, $link, $label, $weight, $parent=null )
 {
  if ( $set == 'tabs' )
  {
   $this->tabs[$name]['link'] = $link;
   $this->tabs[$name]['label'] = $label;
   $this->tabs[$name]['weight'] = $weight;
   $this->tabs[$name]['name'] = $name;
  } elseif ( $set == 'subs' ){
   $this->subs[$parent][$name]['link'] = $link;
   $this->subs[$parent][$name]['label'] = $label;
   $this->subs[$parent][$name]['weight'] = $weight;
   $this->subs[$parent][$name]['name'] = $name;
  }
 }

/**
 * Method is used to clear all assigned sub links
 * @param   void
 */
 function clearSubs()
 {
  $this->subs = null;
 }

/**
 * Method is used to build a complete set of data which can then be easily used
 * to display tabs in a webpage. This method should not be called directly and 
 * can be accessed via the getSet() method.
 * @return  array   full tab data and sub links for active tab
 * 
 */
 function fetchTabSet()
 {
  $set['tabs'] = $this->tabs;	
  $subs = $this->subs;
  foreach ( $subs as $k=>$v )
  {
   if ( $k == $this->current_tab )
   {
    $set['subs'] = $v;
   }
  }
  if ( isset($this->current_tab) ){
   $set['tabs'][$this->current_tab]['current'] = 1;
  }
  if ( isset($this->current_sub) ){
      $set['subs'][$this->current_sub]['current'] = 1;
  }
  $set['tabcount'] = count($set['tabs']);
  if ( isset($set['subs'])) {
   $set['subcount'] = count($set['subs']);
  } 

 return $set;	
 }
 
  /**
  * Return the html which makes up the tabs.
  */
 function render()
 {
   $html = '';
   if ( $this->_return_style ) $html .= $this->getStyle();
   $tabs = $this->getSet();
   $html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n
		  <tr>\n
			<td><div id='".$this->_style."'>\n
		  <ul>\n";
   foreach ( $tabs['tabs'] as $k=>$tab )
   {
     $html .= "<li";
	 if ( $tab['current'] == 1 ) $html .= " id='current'";
	 $html .= "><a href='".$tab['link']."'>".$tab['label']."</a></li>\n";
   }
	  $html .= "<li id='rightside'>".$this->_righttxt."</li>\n
	 	  </ul>\n
		</div></td>\n
		  </tr>\n
		  <tr>\n
			<td height='30'>\n
			<div>&nbsp; &nbsp;";
   $n = 0;
   foreach ( $tabs['subs'] as $k=>$sub )
   {
     if ( $n > 0 ) $html .= "| &nbsp;"; 
   	 $html .= "<a href='".$sub['link']."'>".$sub['label']."</a> &nbsp;";
   $n++;
   }
     $html .= "</div>\n
			</td>\n
		  </tr>\n
		</table>";	 
   echo 'llmjklmklm '.$html;				
   return $html;

 }
 
/**
* Create a default style sheet
*/ 
 function getStyle()
 {
    $style = "<style type='text/css' media='screen'>
		#xtabs {
		  float:left;
		  width:100%;
		  background:#DAE0D2 url('".XOOPS_URL."/images/bg.gif') repeat-x bottom;
		  font-size:93%;
		  line-height:normal;
		  }		\r\n
		#xtabs ul {
		  margin:0;
		  padding:10px 10px 0;
		  list-style:none;
		  }		\r\n
		#xtabs li {
		  float:left;
		  background:url('".XOOPS_URL."/images/left.gif') no-repeat left top;
		  margin:0;
		  padding:0 0 0 9px;
		  list-style:none;
		 }		\r\n
		#xtabs a {
		  float:left;
		  display:block;
		  background:url('".XOOPS_URL."/images/right.gif') no-repeat right top;
		  padding:5px 15px 4px 6px;
		  text-decoration:none;
		  font-weight:bold;
		  color:#765;
		  }		\r\n
		/* Commented Backslash Hack
		   hides rule from IE5-Mac \*/  		\r\n
		#xtabs a {float:none;} 		\r\n
		/* End IE5-Mac hack */ 		\r\n
		#xtabs a:hover {
		  color:#333;
		  }		\r\n
		#xtabs #current {
		  background-image:url('".XOOPS_URL."/images/left_on.gif');
		  }		\r\n
		#xtabs #current a {
		  background-image:url('".XOOPS_URL."/images/right_on.gif');
		  color:#333;
		  padding-bottom:5px;
		  }		\r\n
		#xtabs #rightside {
		  float:right;
		  background:none;
		  }		\r\n
		</style>
	";
	return $style;
 }

} // END CLASS


?>

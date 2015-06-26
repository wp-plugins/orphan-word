<?php
/**
 * Plugin Name: Orphan Word
 * Author: olarmarius
 * Version: 1.0
 * Description: This plugin will handle the orphan words from: post/page title, widget title, widget text and comment text. An orphan is the first line of a paragraph that lands all by itself at the bottom of a column or page. Designers sometimes also refer to the single-word last line of a paragraph as either a widow or an orphan. Some people call this a “runt”.
 * Tags: orphan, orphans, orphan word, automatic, typography, style, design, readability, posts, page, title, comment, widget, filter, typesetting, paragraph, white space
 * License: GPL v3 or later
 */

// http://en.wikipedia.org/wiki/Widows_and_orphans
// http://danielmall.com/articles/responsive-line-breaks/
// http://css-tricks.com/preventing-widows-in-post-titles/

class Orphan_Word {
	public function __construct() {
		add_filter( 'the_title', array( $this, 'orphan_filer' ), 999, 1 );
		add_filter( 'widget_title', array( $this, 'orphan_filer' ), 999, 1 );
		add_filter( 'widget_text', array( $this, 'orphan_filer' ), 999, 1 );
		add_filter( 'get_comment_text', array( $this, 'orphan_filer' ), 999, 1 );
	}

	public function orphan_filer( $content ) {
		// get the words of the content
		$words = explode( ' ', $content );

		// count the words
		$words_count  = count( $words );

		// if the content is up to 3 words the content remain the same
		if ( 4 > $words_count ) {
			return $content;
		}

		// get the words without the last two
		$new_words = array_slice( $words, 0, $words_count - 2 );

		// get the previous last word
		$prelast_word = $words[ $words_count - 2 ];

		// get the last word
		$last_word = $words [ $words_count - 1 ];

		// return the words and the previous last word and the last word linked with the '&nbsp;' instead of ' ' symbol
		return implode( ' ', $new_words ) . ' ' . $prelast_word . '&nbsp;' . $last_word;
	}
}
new Orphan_Word();

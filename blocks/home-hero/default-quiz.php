<?php
/**
 * Starter quiz. Question 1 is from the design; questions 2 to 4 are starter content to replace.
 * Each answer carries a tag; the product whose tags match the most answers is the pick.
 */
$o = function ( $label, $tag ) {
	return array( 'label' => $label, 'tag' => $tag );
};
return array(
	array( 'question' => 'Who are you looking for support for?', 'options' => array( $o( 'A student (me)', 'student' ), $o( 'My child', 'parent' ), $o( 'A school or trust', 'school' ), $o( 'A local authority', 'council' ) ) ),
	array( 'question' => 'What stage is the student at?', 'options' => array( $o( 'Ages 11 to 14', 'ks3' ), $o( 'GCSE', 'gcse' ), $o( 'A-level', 'alevel' ), $o( 'Applying to university', 'university' ) ) ),
	array( 'question' => 'What matters most right now?', 'options' => array( $o( 'Raising grades', 'grades' ), $o( 'Studying flexibly', 'flexible' ), $o( 'Real career experience', 'career' ), $o( 'Specialist SEND support', 'send' ) ) ),
	array( 'question' => 'How would you like to learn?', 'options' => array( $o( 'Live with a tutor', 'live' ), $o( 'Self-paced online', 'selfpaced' ), $o( 'In person with a group', 'inperson' ), $o( 'Free resources first', 'free' ) ) ),
);

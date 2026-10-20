<?php
/**
 * Starter content for the finder's search and quiz results.
 * Not from the design (the design only shows the empty search box): replace with real products in the block.
 * tags: comma-separated quiz answer tags this product matches.
 */
$p = function ( $title, $desc, $kind, $url, $keywords, $tags ) {
	return array( 'title' => $title, 'description' => $desc, 'kind' => $kind, 'link' => array( 'title' => $title, 'url' => $url ), 'keywords' => $keywords, 'tags' => $tags );
};
return array(
	$p( '1:1 Tutoring', 'Personalised tutoring to fill the gaps and hit target grades.', 'Tutoring', '/our-services/1-1-tutoring', 'tutor tuition gcse a-level maths english science 11+ ks3', 'student,parent,ks3,gcse,alevel,grades,live' ),
	$p( 'Online Courses', 'Self-paced online courses for in-depth subject learning.', 'Course', '/our-services/online-courses', 'course online self-paced revision gcse a-level', 'student,parent,gcse,alevel,flexible,selfpaced' ),
	$p( 'Summer Career Camps', 'Ages 15 to 18: an immersive week in your dream career.', 'Camp', '/summer-career-camps', 'camp summer career work experience medicine law business engineering', 'student,parent,alevel,career,inperson' ),
	$p( 'SEND and Alternative Provision', 'Specialist SEND and AP tutors with personalised learning plans.', 'Provision', '/alternative-provision', 'send ap alternative provision ehcp special needs school council', 'school,council,parent,send,live' ),
	$p( 'Resources for Schools', 'Free resources for students and teachers.', 'Free', '/resources', 'free resources revision notes past papers study guide teachers', 'school,student,free,resources' ),
	$p( 'Revision Notes', 'Free revision notes for GCSE and A-level subjects.', 'Free', '/resources/revision-notes', 'revision notes free gcse a-level', 'student,gcse,alevel,free,resources' ),
	$p( 'Past Papers', 'Free past papers by exam board and subject.', 'Free', '/resources/past-papers', 'past papers exam board aqa edexcel ocr free', 'student,gcse,alevel,free,resources' ),
	$p( 'Medic Mind: UCAT and medicine', 'UCAT courses, interviews and full medicine applications.', 'Sister brand', 'https://www.medicmind.co.uk', 'ucat medicine medical school mmi interview gamsat doctor', 'student,parent,university,career' ),
	$p( 'Oxbridge Mind', 'Oxford and Cambridge application, interview and exam prep.', 'Sister brand', 'https://www.oxbridgemind.co.uk', 'oxbridge oxford cambridge interview admissions test', 'student,parent,university' ),
	$p( 'Law Mind: LNAT and law', 'LNAT courses, interview tutoring and law work experience.', 'Sister brand', 'https://www.lawmind.co.uk', 'lnat law solicitor barrister', 'student,parent,university,career' ),
	$p( '11+ Tutoring', '11+ preparation with specialist tutors.', 'Tutoring', '/our-services/1-1-tutoring', '11+ eleven plus entrance grammar ks2', 'parent,ks3,grades,live' ),
);
